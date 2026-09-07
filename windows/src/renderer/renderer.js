const PORT = 8080;
let mode = 'wifi';

const wifiModeBtn = document.getElementById('wifiModeBtn');
const usbModeBtn = document.getElementById('usbModeBtn');
const wifiPanel = document.getElementById('wifiPanel');
const usbPanel = document.getElementById('usbPanel');
const statusBox = document.getElementById('statusBox');
const urlBox = document.getElementById('urlBox');
const ipInput = document.getElementById('ipInput');

function setMode(m) {
  mode = m;
  wifiModeBtn.classList.toggle('active', m === 'wifi');
  usbModeBtn.classList.toggle('active', m === 'usb');
  wifiPanel.style.display = m === 'wifi' ? 'block' : 'none';
  usbPanel.style.display = m === 'usb' ? 'block' : 'none';
  setStatus('Not connected', null);
  urlBox.textContent = 'http://—';
}

function setStatus(text, ok) {
  statusBox.textContent = text;
  statusBox.className = 'status' + (ok === true ? ' ok' : ok === false ? ' err' : '');
}

wifiModeBtn.onclick = () => setMode('wifi');
usbModeBtn.onclick = () => setMode('usb');

document.getElementById('checkBtn').onclick = async () => {
  const ip = ipInput.value.trim();
  if (!ip) return setStatus('Enter phone IP first', false);
  setStatus('Checking...', null);
  const ok = await window.api.checkWifi(ip);
  if (ok) {
    setStatus('Connected', true);
    urlBox.textContent = `http://${ip}:${PORT}/video`;
  } else {
    setStatus('Could not reach phone. Check IP and WiFi network.', false);
    urlBox.textContent = 'http://—';
  }
};

document.getElementById('usbConnectBtn').onclick = async () => {
  setStatus('Connecting...', null);
  try {
    await window.api.usbConnect();
    setStatus('Connected via USB', true);
    urlBox.textContent = `http://localhost:${PORT}/video`;
  } catch (e) {
    setStatus(e.message || 'USB connect failed', false);
    urlBox.textContent = 'http://—';
  }
};

document.getElementById('copyBtn').onclick = () => {
  window.api.copyUrl(urlBox.textContent);
  setStatus('URL copied to clipboard', true);
};
