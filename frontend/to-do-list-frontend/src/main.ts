import { createApp } from 'vue';
import App from './App.vue';
import { Notify, Quasar } from 'quasar';

import 'quasar/dist/quasar.css';
import { router } from './navigation/router';

const app = createApp(App);
app.use(Quasar, {
    plugins: {
      Notify
    },
    config: {
      notify:{
        
      }
    }
  })
app.use(Quasar);
app.use(router); // Usa o Vue Router
app.mount('#app');
