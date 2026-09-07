const { app, BrowserWindow, ipcMain, clipboard, shell } = require('electron');
const path = require('path');
const http = require('http');
const { spawn } = require('child_process');

const PORT = 8899;
let win;

function adbPath() {
  const base = app.isPackaged
    ? path.join(process.resourcesPath, 'adb')
    : path.join(__dirname, '..', 'resources', 'adb');
  return path.join(base, 'adb.exe');
}

function runAdb(args) {
  return new Promise((resolve, reject) => {
    const proc = spawn(adbPath(), args);
    let out = '', err = '';
    proc.stdout.on('data', (d) => (out += d));
    proc.stderr.on('data', (d) => (err += d));
    proc.on('close', (code) => {
      if (code === 0) resolve(out.trim());
      else reject(new Error(err.trim() || `adb exited ${code}`));
    });
    proc.on('error', reject);
  });
}

ipcMain.handle('check-wifi', async (_e, ip) => {
  return new Promise((resolve) => {
    const req = http.get({ host: ip, port: PORT, path: '/', timeout: 3000 }, (res) => {
      resolve(res.statusCode === 200);
      res.resume();
    });
    req.on('error', () => resolve(false));
    req.on('timeout', () => { req.destroy(); resolve(false); });
  });
});

ipcMain.handle('usb-connect', async () => {
  const devices = await runAdb(['devices']);
  const lines = devices.split('\n').slice(1).filter((l) => l.includes('\tdevice'));
  if (lines.length === 0) throw new Error('No device found. Enable USB debugging and plug in phone.');
  await runAdb(['forward', `tcp:${PORT}`, `tcp:${PORT}`]);
  return true;
});

ipcMain.handle('usb-disconnect', async () => {
  try { await runAdb(['forward', '--remove', `tcp:${PORT}`]); } catch (_) {}
  return true;
});

ipcMain.handle('copy-url', (_e, url) => {
  clipboard.writeText(url);
});

ipcMain.handle('open-url', (_e, url) => {
  shell.openExternal(url);
});

function createWindow() {
  win = new BrowserWindow({
    width: 420,
    height: 480,
    resizable: false,
    icon: path.join(__dirname, '..', 'build', 'icon.png'),
    webPreferences: {
      preload: path.join(__dirname, 'preload.js'),
    },
  });
  win.loadFile(path.join(__dirname, 'renderer', 'index.html'));
}

app.whenReady().then(createWindow);
app.on('window-all-closed', () => app.quit());
