@echo off
setlocal enabledelayedexpansion

REM Leggi la versione corrente dal composer.json
for /f "tokens=2 delims=:," %%a in ('findstr "version" composer.json') do (
    set "version=%%~a"
    set "version=!version:"=!"
    set "version=!version: =!"
)

REM Dividi la versione in parti
for /f "tokens=1,2,3 delims=." %%a in ("!version!") do (
    set major=%%a
    set minor=%%b
    set patch=%%c
)

REM Incrementa la versione
set /a patch+=1
if !patch! gtr 9 (
    set patch=0
    set /a minor+=1
    if !minor! gtr 9 (
        set minor=0
        set /a major+=1
    )
)

REM Componi la nuova versione
set "new_version=!major!.!minor!.!patch!"

REM Aggiorna il composer.json
powershell -Command "(Get-Content composer.json) -replace '\"version\": \".*\"', '\"version\": \"!new_version!\"' | Set-Content composer.json"

REM Esegui i comandi git
git add .
git commit -m "update !new_version!"
git push origin main
git tag !new_version!
git push origin !new_version!

echo Versione aggiornata a !new_version! e push completato.
