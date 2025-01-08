<template>
    <q-page class="flex flex-center">
        <q-card class="register-card" style="width: 400px;">
            <q-card-section>
                <div class="text-h6">Cadastrar Usuário</div>
                <q-form @submit="onSubmit" class="q-gutter-md">
                    <q-input v-model="name" label="Nome" type="text"
                        :rules="[(val: any) => !!val || 'O nome é obrigatório']" lazy-rules />
                    <q-input v-model="email" label="Email" type="email"
                        :rules="[(val: any) => !!val || 'O email é obrigatório']" lazy-rules />
                    <q-input v-model="password" label="Senha" type="password"
                        :rules="[(val: any) => !!val || 'A senha é obrigatória']" lazy-rules />
                    <q-input v-model="passwordConfirmation" label="Confirmar Senha" type="password"
                        :rules="[(val: any) => val === password || 'As senhas não conferem']" lazy-rules />
                    <q-btn label="Cadastrar" type="submit" color="primary" class="full-width" :loading="loading"
                        :disable="loading" />
                </q-form>
            </q-card-section>
            <q-card-actions>
                <q-btn flat label="Já tem uma conta?" to="/" />
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
    name: 'RegisterPage',
    setup() {
        const name = ref('');
        const email = ref('');
        const password = ref('');
        const passwordConfirmation = ref('');
        const loading = ref(false); 
        const router = useRouter();

        const onSubmit = async () => {
            if (!name.value || !email.value || !password.value || !passwordConfirmation.value) {
                showToast({
                    message: 'Por favor, preencha todos os campos!',
                    title: 'Erro de Cadastro',
                    color: 'red',
                    position: 'top',
                    timeout: 3000,
                });
                return;
            }

            loading.value = true; 

            try {
                await httpClient.post('/register', {
                    name: name.value,
                    email: email.value,
                    password: password.value,
                    password_confirmation: passwordConfirmation.value,
                });

                showToast({
                    message: 'Cadastro realizado com sucesso!',
                    title: 'Sucesso',
                    color: 'green',
                    position: 'top',
                    timeout: 3000,
                });

                router.push('/'); 
            } catch (error) {
                const errorMessage =
                    'Erro ao cadastrar usuário. Tente novamente.';
                showToast({
                    message: errorMessage,
                    title: 'Erro de Cadastro',
                    color: 'red',
                    position: 'top',
                    timeout: 3000,
                });
            } finally {
                loading.value = false; 
            }
        };

        return {
            name,
            email,
            password,
            passwordConfirmation,
            onSubmit,
            loading,
        };
    },
});
</script>

<style scoped>
.register-card {
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