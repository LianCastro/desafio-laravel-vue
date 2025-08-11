<template>
  <div>
    <h1>{{ usuario.id ? 'Editar Usuário' : 'Novo Usuário' }}</h1>

    <form @submit.prevent="salvarUsuario">
      <input v-model="usuario.nome" placeholder="Nome" required />
      <input v-model="usuario.email" placeholder="Email" required />
      <input v-model="usuario.cpf" placeholder="CPF" required />

      <select v-model="usuario.perfil_id" required>
        <option value="">Selecione um perfil</option>
        <option v-for="p in perfis" :key="p.id" :value="p.id">{{ p.nome }}</option>
      </select>

      <button type="submit">Salvar</button>
    </form>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  props: ['id'],
  data() {
    return {
      usuario: { nome: '', email: '', cpf: '', perfil_id: '' },
      perfis: []
    };
  },
  methods: {
    async carregarPerfis() {
      const { data } = await api.get('/perfis');
      this.perfis = data;
    },
    async carregarUsuario() {
      if (this.id) {
        const { data } = await api.get(`/usuarios/${this.id}`);
        this.usuario = { ...data };
      }
    },
    async salvarUsuario() {
      if (this.usuario.id) {
        await api.put(`/usuarios/${this.usuario.id}`, this.usuario);
      } else {
        await api.post('/usuarios', this.usuario);
      }
      this.$router.push('/usuarios');
    }
  },
  mounted() {
    this.carregarPerfis();
    this.carregarUsuario();
  }
};
</script>
