<template>
  <div class="container mt-4">
    <h1 class="mb-4">{{ usuario.id ? 'Editar Usuário' : 'Novo Usuário' }}</h1>

    <form @submit.prevent="salvarUsuario" class="card p-4 shadow-sm">
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input v-model="usuario.nome" class="form-control" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input v-model="usuario.email" type="email" class="form-control" required />
      </div>

      <div class="mb-3">
        <label class="form-label">CPF</label>
        <input
          v-model="usuario.cpf"
          v-mask="'###.###.###-##'"
          class="form-control"
          placeholder="000.000.000-00"
          required
        />
      </div>

      <div class="mb-3">
        <label class="form-label">Perfil</label>
        <select v-model="usuario.perfil_id" class="form-select form-select-lg border-primary shadow-sm w-50" required>
          <option value="">Selecione um perfil</option>
          <option v-for="p in perfis" :key="p.id" :value="p.id">
            {{ p.nome }}
          </option>
        </select>
      </div>

      <!-- Endereços -->
      <h4 class="mt-4">Endereços</h4>

      <div v-for="(endereco, index) in usuario.enderecos" :key="index" class="card p-3 mb-3">
        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Logradouro</label>
            <input v-model="endereco.logradouro" class="form-control" required />
          </div>
          <div class="col-md-4 mb-2">
            <label class="form-label">CEP</label>
            <input v-model="endereco.cep" v-mask="'#####-###'" class="form-control" required />
          </div>
        </div>
        <button type="button" class="btn btn-danger btn-sm mt-2" @click="removerEndereco(index)">
          Remover Endereço
        </button>
      </div>

      <button type="button" class="btn btn-outline-primary mb-3" @click="adicionarEndereco">
        + Adicionar Endereço
      </button>

      <div class="d-flex justify-content-between">
        <router-link to="/usuarios" class="btn btn-secondary">Voltar</router-link>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
  </div>
</template>


<script>
import api from '../services/api';

export default {
  props: ['id'],
  data() {
    return {
      usuario: { nome: '', email: '', cpf: '', perfil_id: '', enderecos: [] },
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
    adicionarEndereco() {
      this.usuario.enderecos.push({
        logradouro: '',
        cep: ''
      });
    },
    removerEndereco(index) {
      this.usuario.enderecos.splice(index, 1);
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
