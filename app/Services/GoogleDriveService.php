<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class GoogleDriveService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $this->client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

        $this->service = new Drive($this->client);
    }

    /**
     * Upload a file to Google Drive
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string|null $folderId
     * @return string|null Web View Link
     */
    public function upload($file, $folderId = null)
    {
        if (!$folderId) {
            $folderId = env('GOOGLE_DRIVE_ROOT_FOLDER_ID');
        }

        $fileMetadata = new DriveFile([
            'name' => $file->getClientOriginalName(),
            'parents' => [$folderId]
        ]);

        $content = file_get_contents($file->getRealPath());

        $uploadedFile = $this->service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getClientMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink, webContentLink'
        ]);

        // Make the file publicly readable (optional, depending on requirements)
        // This makes it viewable by anyone with the link
        try {
            $permission = new \Google\Service\Drive\Permission();
            $permission->setRole('reader');
            $permission->setType('anyone');
            $this->service->permissions->create($uploadedFile->id, $permission);
        } catch (\Exception $e) {
            // Handle permission error or ignore
        }

        return $uploadedFile->webViewLink;
    }
}
