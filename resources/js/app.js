import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';

console.log("Vue is initializing...");

try {
    const app = createApp(App);
    app.mount('#app');
    console.log("Vue mounted to #app successfully.");
} catch (e) {
    console.error("Vue mounting failed:", e);
}
