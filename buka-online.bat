@echo off
title Buka Online Sistem Pengarsipan RT 005
color 0A
echo ===============================================================
echo   SISTEM INFORMASI PELAYANAN & PENGARSIPAN WARGA RT 005
echo   Perumahan Bumi Mutiara Indah II
echo ===============================================================
echo.
echo [1/2] Memastikan server lokal aktif...
echo [2/2] Membuka jalur publik online (HTTPS)...
echo.
echo ===============================================================
echo   SALIN LINK BERIKUT UNTUK DIBUKA DI HP / ORANG LAIN:
echo ===============================================================
echo.
ssh -o StrictHostKeyChecking=no -R 80:127.0.0.1:8000 nokey@localhost.run
pause

