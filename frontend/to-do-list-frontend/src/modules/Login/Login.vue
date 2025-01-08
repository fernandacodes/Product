<template>
  <q-page class="flex flex-center">
    <q-card class="login-card" style="width: 400px;">
      <q-card-section>
        <div class="text-h6">Login</div>
        <q-form @submit="onSubmit" class="q-gutter-md">
          <q-input
            v-model="email"
            label="Email"
            type="email"
            :rules="[(val: any) => !!val || 'O email é obrigatório']"
            lazy-rules
          />
          <q-input
            v-model="password"
            label="Senha"
            type="password"
            :rules="[(val: any) => !!val || 'A senha é obrigatória']"
            lazy-rules
          />
          <q-btn
            label="Entrar"
            type="submit"
            color="primary"
            class="full-width"
            :loading="loading"
            :disable="loading"
          />
        </q-form>
      </q-card-section>
      <q-card-actions>
        <q-btn flat label="Não tem uma conta?" to="/register" />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { httpClient } from '../../infrastructure/configuration';
import { useRouter } from 'vue-router';
import { showToast } from '../../dls/components/Toast';

export default defineComponent({
  name: 'LoginPage',
  setup() {
    const email = ref('');
    const password = ref('');
    const loading = ref(false); // Para controlar o estado de carregamento
    const router = useRouter();

    const onSubmit = async () => {
      if (!email.value || !password.value) {
        showToast({
          message: 'Por favor, preencha todos os campos!',
          title: 'Erro de Login',
          color: 'red',
          position: 'top',
          timeout: 3000,
        });
        return;
      }

      loading.value = true; // Desabilitar o botão enquanto a requisição está sendo processada

      try {
        const response = await httpClient.post<{ token: string }>('/login', {
          email: email.value,
          password: password.value,
        });
        
        localStorage.setItem('authToken', response.token);
        router.push('/home');
        
        showToast({
          message: 'Login realizado com sucesso!',
          title: 'Sucesso',
          color: 'green',
          position: 'top',
          timeout: 3000,
        });
      } catch (error) {
        showToast({
          message: 'Erro ao fazer login. Verifique suas credenciais!',
          title: 'Erro',
          color: 'red',
          position: 'top',
          timeout: 3000,
        });
      } finally {
        loading.value = false; // Reabilitar o botão
      }
    };

    return {
      email,
      password,
      onSubmit,
      loading,
    };
  },
});
</script>

<style scoped>
.login-card {
  max-width: 400px;
  width: 100%;
}

.q-page {
  background-color: #f7f7f7;
}

.q-btn {
  width: 100%;
}
</style>
