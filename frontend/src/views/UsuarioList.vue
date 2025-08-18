<template>
  <div class="container mt-4">
    <h1 class="mb-4">Usuários</h1>

    <!-- Filtros -->
    <div class="row mb-3">
      <div class="col-md-3">
        <input v-model="filtro.nome" class="form-control" placeholder="Filtrar por nome" />
      </div>
      <div class="col-md-3">
        <input v-model="filtro.cpf" class="form-control" placeholder="Filtrar por CPF" />
      </div>
      <div class="col-md-3">
        <button @click="carregarUsuarios" class="btn btn-primary w-100">Filtrar</button>
      </div>
      <div class="col-md-3 text-end">
        <router-link to="/usuarios/novo" class="btn btn-success">Novo Usuário</router-link>
      </div>
    </div>

    <!-- Tabela -->
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
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
            <router-link :to="`/usuarios/${u.id}`" class="btn btn-sm btn-warning me-2">Editar</router-link>
            <button @click="excluirUsuario(u.id)" class="btn btn-sm btn-danger">Excluir</button>
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
