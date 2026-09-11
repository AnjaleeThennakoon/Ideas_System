import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['x-Requested-With'] = 'XMLHttpRequest';
