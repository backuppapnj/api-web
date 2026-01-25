import re

file_path = 'database/seeders/data.sql'

with open(file_path, 'r') as f:
    lines = f.readlines()

# Pattern to extract nomor_perkara
pattern = re.compile(r"^\s*\(\d+,\s*'([^']+)'")

# 1. Identify duplicates
# valid_lines stores metadata about lines that look like tuples
# format: {index: i, key: nomor_perkara}
tuple_lines = []
for i, line in enumerate(lines):
    match = pattern.search(line)
    if match:
        tuple_lines.append({'index': i, 'key': match.group(1).lower()})

# Filter to keep only the LAST occurrence of each key
seen_keys = set()
indices_to_remove = set()

# Process backwards
for item in reversed(tuple_lines):
    if item['key'] in seen_keys:
        indices_to_remove.add(item['index'])
    else:
        seen_keys.add(item['key'])

# 2. Build new line list
new_lines = []
for i, line in enumerate(lines):
    if i in indices_to_remove:
        continue
    new_lines.append(line.rstrip()) # strip newline/spaces for processing

# 3. Fix Punctuation
# We need to ensure that within a block of tuples, they are comma-separated,
# and the last one is semicolon-terminated.
# We define a "tuple line" as one matching the pattern.
final_lines = []
for i, line in enumerate(new_lines):
    # Check if this line is a tuple line
    is_tuple = bool(pattern.search(line))
    
    if is_tuple:
        # Check next line
        is_next_tuple = False
        if i + 1 < len(new_lines):
            is_next_tuple = bool(pattern.search(new_lines[i+1]))
        
        # Clean existing punctuation
        content = line.strip()
        if content.endswith(',') or content.endswith(';'):
            content = content[:-1]
            
        if is_next_tuple:
            final_lines.append(content + ',')
        else:
            final_lines.append(content + ';')
    else:
        final_lines.append(line)

# Write back
with open(file_path, 'w') as f:
    f.write('\n'.join(final_lines) + '\n')

print(f"Fixed duplicates. Removed {len(indices_to_remove)} lines.")
