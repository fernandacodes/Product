<script setup lang="ts">
import { QLayout, QPageContainer, QPage, QBtn } from 'quasar';
import { onMounted } from 'vue';
import { showToast } from './dls/components/Toast';

onMounted(() => {
  showToast({
    message: 'Página carregada com sucesso!',
    title: 'Bem-vindo',
    color: 'green',
    position: 'top',
    timeout: 3000,
  });
});

</script>

<template>
  <QLayout view="lHh Lpr lFf">
    <QPageContainer>
      <QPage>
        <router-view />
      </QPage>
    </QPageContainer>
  </QLayout>
</template>

<style scoped>
</style>
