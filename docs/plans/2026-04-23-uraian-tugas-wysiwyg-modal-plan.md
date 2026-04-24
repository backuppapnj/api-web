# WYSIWYG Editor + Modal Uraian Tugas Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Add TipTap WYSIWYG editor to uraian-tugas admin forms and add modal popup to Joomla integration for displaying uraian tugas content.

**Architecture:** Reusable TipTap editor component in admin-panel (Next.js + shadcn/ui) with text formatting only. Joomla integration uses vanilla JS/CSS modal compatible with Joomla 3.

**Tech Stack:** TipTap (@tiptap/react, @tiptap/starter-kit), Next.js, shadcn/ui, vanilla JS/CSS

---

### Task 1: Install TipTap Dependencies

**Files:**
- Modify: `admin-panel/package.json`

**Step 1: Install packages**

Run:
```bash
cd e:/project/admin-panel && npm install @tiptap/react @tiptap/starter-kit @tiptap/extension-placeholder
```

Expected: packages installed successfully, no peer dependency conflicts.

**Step 2: Verify installation**

Check `node_modules/@tiptap/react` exists.

---

### Task 2: Create Reusable TiptapEditor Component

**Files:**
- Create: `admin-panel/components/TiptapEditor.tsx`

**Step 1: Write component**

Create `admin-panel/components/TiptapEditor.tsx` with:
- `useEditor` hook from `@tiptap/react`
- `StarterKit` extension
- `Placeholder` extension (placeholder text: "Tulis uraian tugas di sini...")
- Toolbar buttons using shadcn `Button` + `lucide-react` icons:
  - Bold (`Bold` icon)
  - Italic (`Italic` icon)
  - Heading 1 (`Heading1` icon)
  - Heading 2 (`Heading2` icon)
  - Bullet List (`List` icon)
  - Ordered List (`ListOrdered` icon)
  - Link (`Link` icon) — prompt for URL
  - Unlink (`LinkBreak` or unlink icon)
- `EditorContent` for editable area
- Props: `content?: string`, `onChange?: (html: string) => void`
- Use `editor?.getHTML()` in `onUpdate` callback to pass HTML to parent
- Styling: border rounded-lg, toolbar with border-bottom, editor area min-height 200px

**Step 2: Verify component compiles**

Run Next.js dev build and check for TypeScript errors.

---

### Task 3: Update TypeScript Interface for UraianTugas

**Files:**
- Modify: `admin-panel/lib/api.ts`

**Step 1: Add uraian_tugas field**

Add `uraian_tugas?: string` to the `UraianTugas` interface around line 1477.

```typescript
export interface UraianTugas {
  id: number;
  nama?: string;
  jabatan: string;
  kelompok_jabatan_id: number;
  nip?: string;
  jenis_pegawai_id?: number;
  foto_url?: string;
  link_dokumen?: string;
  uraian_tugas?: string;  // <-- ADD THIS
  urutan: number;
  kelompok_jabatan?: KelompokJabatan;
  jenis_pegawai?: JenisPegawai;
  created_at?: string;
  updated_at?: string;
}
```

---

### Task 4: Update Tambah Page with WYSIWYG

**Files:**
- Modify: `admin-panel/app/uraian-tugas/tambah/page.tsx`

**Step 1: Import TiptapEditor**

Add import:
```typescript
import { TiptapEditor } from '@/components/TiptapEditor';
```

**Step 2: Add uraian_tugas field to form**

After the "Link Dokumen" field and before "Urutan Tampil", add:

```tsx
{/* Uraian Tugas WYSIWYG */}
<div className="space-y-2">
  <Label>Uraian Tugas <span className="text-muted-foreground text-xs">(opsional)</span></Label>
  <TiptapEditor
    content={formData.uraian_tugas || ''}
    onChange={(html) => set('uraian_tugas', html)}
  />
</div>
```

---

### Task 5: Update Edit Page with WYSIWYG

**Files:**
- Modify: `admin-panel/app/uraian-tugas/[id]/edit/page.tsx`

**Step 1: Import TiptapEditor**

Add import:
```typescript
import { TiptapEditor } from '@/components/TiptapEditor';
```

**Step 2: Add uraian_tugas field to form**

After the "Link Dokumen" field and before "Urutan Tampil", add:

```tsx
{/* Uraian Tugas WYSIWYG */}
<div className="space-y-2">
  <Label>Uraian Tugas <span className="text-muted-foreground text-xs">(opsional)</span></Label>
  <TiptapEditor
    content={formData.uraian_tugas || ''}
    onChange={(html) => set('uraian_tugas', html)}
  />
</div>
```

---

### Task 6: Update Joomla Integration — Modal + Bug Fix

**Files:**
- Modify: `api-web/docs/joomla-integration-uraian-tugas.html`

**Step 1: Add modal CSS**

Add modal styles inside the `<style>` block (before closing `</style>`):

```css
/* ===== MODAL ===== */
.ut-modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
    backdrop-filter: blur(4px);
}
.ut-modal-overlay.active {
    display: flex;
}
.ut-modal {
    background: #ffffff;
    border-radius: 16px;
    max-width: 700px;
    width: 100%;
    max-height: 80vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: ut-modalIn 0.25s ease-out;
}
@keyframes ut-modalIn {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.ut-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 24px;
    border-bottom: 1px solid #e2e8f0;
}
.ut-modal-title {
    font-size: 17px;
    font-weight: 700;
    color: #1e293b;
}
.ut-modal-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: #64748b;
    transition: color 0.2s;
}
.ut-modal-close:hover {
    color: #0f766e;
}
.ut-modal-body {
    padding: 24px;
    overflow-y: auto;
    font-size: 14px;
    line-height: 1.7;
    color: #334155;
}
.ut-modal-body h1,
.ut-modal-body h2,
.ut-modal-body h3 {
    margin-top: 0;
    color: #1e293b;
}
.ut-modal-body ul,
.ut-modal-body ol {
    padding-left: 20px;
}
.ut-modal-body a {
    color: #0d9488;
    text-decoration: underline;
}

/* Card clickable indicator */
.ut-card.has-detail {
    cursor: pointer;
    position: relative;
}
.ut-card.has-detail::after {
    content: '';
    position: absolute;
    top: 12px; right: 12px;
    width: 8px; height: 8px;
    background: #0d9488;
    border-radius: 50%;
}
```

**Step 2: Add modal HTML**

Add modal markup inside `.ut-wrapper` (after `<div id="ut-tab-content"></div>`):

```html
<!-- Modal Uraian Tugas -->
<div class="ut-modal-overlay" id="ut-modal-overlay" onclick="utCloseModal(event)">
    <div class="ut-modal">
        <div class="ut-modal-header">
            <span class="ut-modal-title" id="ut-modal-title">Uraian Tugas</span>
            <button class="ut-modal-close" onclick="utCloseModalDirect()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="ut-modal-body" id="ut-modal-body"></div>
    </div>
</div>
```

**Step 3: Update card creation logic**

In `utMakeCard`, replace the badge HTML logic and add click handler:

```javascript
var hasDetail = !!item.uraian_tugas;
var badgeHtml = item.jenis_pegawai
    ? '<span class="ut-badge ut-badge-' + escHtml(item.jenis_pegawai.nama) + '">' + escHtml(item.jenis_pegawai.nama) + '</span>'
    : '';
```

Update card class:
```javascript
card.className = 'ut-card' + (hasDetail ? ' has-detail' : '');
```

Add click handler if has detail:
```javascript
if (hasDetail) {
    card.onclick = function() { utOpenModal(item); };
}
```

**Step 4: Add modal JS functions**

Add inside the IIFE, before `utInit()`:

```javascript
function utOpenModal(item) {
    document.getElementById('ut-modal-title').textContent = 'Uraian Tugas — ' + (item.nama || item.jabatan);
    document.getElementById('ut-modal-body').innerHTML = item.uraian_tugas;
    document.getElementById('ut-modal-overlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function utCloseModalDirect() {
    document.getElementById('ut-modal-overlay').classList.remove('active');
    document.body.style.overflow = '';
}

function utCloseModal(event) {
    if (event.target.id === 'ut-modal-overlay') {
        utCloseModalDirect();
    }
}

window.utCloseModal = utCloseModal;
window.utCloseModalDirect = utCloseModalDirect;
```

**Step 5: Fix status_kepegawaian bug**

Replace old badge logic from `status_kepegawaian` to use `jenis_pegawai.nama`.

---

### Task 7: Test Admin Panel Forms

**Files:**
- Run dev server: `admin-panel`

**Step 1: Start dev server**

```bash
cd e:/project/admin-panel && npm run dev
```

**Step 2: Verify Tambah page**
- Navigate to `/uraian-tugas/tambah`
- Confirm WYSIWYG editor renders below "Link Dokumen"
- Type text, apply formatting (bold, list, heading)
- Submit form and verify `uraian_tugas` is saved

**Step 3: Verify Edit page**
- Navigate to `/uraian-tugas/1/edit`
- Confirm WYSIWYG editor pre-populates with existing content
- Edit content, save, verify update persists

---

### Task 8: Test Joomla Integration

**Files:**
- Open `api-web/docs/joomla-integration-uraian-tugas.html` in browser

**Step 1: Verify modal behavior**
- Cards with `uraian_tugas` data show green dot indicator
- Clicking card opens modal with rendered HTML content
- Modal close button and overlay click both close modal
- Cards without `uraian_tugas` are not clickable

**Step 2: Verify bug fix**
- Badge status shows correct jenis pegawai name
- No JavaScript errors in console
