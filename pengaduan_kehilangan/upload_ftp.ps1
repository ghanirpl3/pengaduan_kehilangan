$ftpBase = "ftp://ftpupload.net/htdocs"
$user = "if0_41606903"
$pass = "heWvN1LDy0Zfxz"
$localBase = "c:\laragon\www\pengaduan_kehilangan"

# Create directories first
$dirs = @(
    "assets",
    "assets/css",
    "assets/js",
    "assets/uploads",
    "config",
    "controllers",
    "models",
    "sql",
    "views",
    "views/admin",
    "views/auth",
    "views/layouts",
    "views/siswa"
)

foreach ($dir in $dirs) {
    Write-Host "Creating dir: $dir"
    curl.exe --ftp-create-dirs -u "${user}:${pass}" "$ftpBase/$dir/" --request "MKD $dir" -s -o NUL 2>$null
    # Just try listing to ensure dir exists
    curl.exe --ftp-create-dirs -u "${user}:${pass}" "$ftpBase/$dir/" --list-only -s -o NUL 2>$null
}

# Upload files
$files = Get-ChildItem -Path $localBase -Recurse -File | Where-Object { $_.Name -ne "upload_ftp.ps1" -and $_.Name -ne ".gitignore" -and $_.Directory.Name -ne ".git" -and $_.FullName -notmatch "\.git\\" }

foreach ($file in $files) {
    $relativePath = $file.FullName.Substring($localBase.Length + 1).Replace("\", "/")
    Write-Host "Uploading: $relativePath"
    curl.exe -T $file.FullName -u "${user}:${pass}" "$ftpBase/$relativePath" --ftp-create-dirs -s 2>$null
    if ($LASTEXITCODE -eq 0) {
        Write-Host "  OK" -ForegroundColor Green
    } else {
        Write-Host "  FAILED" -ForegroundColor Red
    }
}

Write-Host "`nUpload complete!" -ForegroundColor Cyan
