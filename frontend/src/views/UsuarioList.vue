<template>
  <div>
    <h1>Usuários</h1>

    <!-- Filtros -->
    <input v-model="filtro.nome" placeholder="Filtrar por nome" />
    <input v-model="filtro.cpf" placeholder="Filtrar por CPF" />
    <button @click="carregarUsuarios">Filtrar</button>
    <router-link to="/usuarios/novo">Novo Usuário</router-link>

    <!-- Tabela -->
    <table border="1">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>CPF</th>
          <th>Perfil</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="u in usuarios" :key="u.id">
          <td>{{ u.nome }}</td>
          <td>{{ u.email }}</td>
          <td>{{ u.cpf }}</td>
          <td>{{ u.perfil?.nome }}</td>
          <td>
            <router-link :to="`/usuarios/${u.id}`">Editar</router-link>
            <button @click="excluirUsuario(u.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  data() {
    return {
      usuarios: [],
      filtro: { nome: '', cpf: '' }
    };
  },
  methods: {
    async carregarUsuarios() {
      const { data } = await api.get('/usuarios', { params: this.filtro });
      this.usuarios = data;
    },
    async excluirUsuario(id) {
      if (confirm('Deseja realmente excluir?')) {
        await api.delete(`/usuarios/${id}`);
        this.carregarUsuarios();
      }
    }
  },
  mounted() {
    this.carregarUsuarios();
  }
};
</script>
