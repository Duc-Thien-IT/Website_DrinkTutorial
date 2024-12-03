import './bootstrap';
import { createApp } from 'vue';

// Tạo ứng dụng Vue
const app = createApp({});

// Nhập component Vue của bạn
import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

// Đăng ký tất cả các component Vue tự động (nếu muốn)
// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

// Gắn Vue app vào phần tử có id "app"
app.mount('#app');
