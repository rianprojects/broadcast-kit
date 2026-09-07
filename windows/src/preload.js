const { contextBridge, ipcRenderer } = require('electron');

contextBridge.exposeInMainWorld('api', {
  checkWifi: (ip) => ipcRenderer.invoke('check-wifi', ip),
  usbConnect: () => ipcRenderer.invoke('usb-connect'),
  usbDisconnect: () => ipcRenderer.invoke('usb-disconnect'),
  copyUrl: (url) => ipcRenderer.invoke('copy-url', url),
  openUrl: (url) => ipcRenderer.invoke('open-url', url),
});
