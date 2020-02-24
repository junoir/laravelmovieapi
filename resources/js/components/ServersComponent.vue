<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-5">
                <h4 class="card-title mb-0">Servers</h4>
              </div>
            </div>
            <hr />

            <!-- Server create -->

            <div class="row">
              <div class="col-12">
                <div class="input-group">
                  <input
                    v-model="form.name"
                    type="text"
                    class="form-control input"
                    placeholder="Server name"
                  />
                  <div class="input-group-btn">
                    <button
                      v-if="!edit"
                      :disabled="!form.name"
                      type="submit"
                      @click.prevent="store()"
                      class="btn btn-primary ml-2"
                    >
                      <i class="material-icons md-16">add</i>
                    </button>

                    <button
                      v-if="edit"
                      :disabled="!form.name"
                      type="submit"
                      @click.prevent="updateSubmit()"
                      class="btn btn-primary ml-2"
                    >
                      <i class="material-icons md-16">update</i>
                    </button>

                    <button
                      v-if="edit"
                      type="button"
                      @click="cancel()"
                      class="btn btn-warning ml-2"
                    >
                      <i class="material-icons md-16">close</i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <br />

            <!-- Servers index -->

            <table class="table table-hover">
              <thead>
                <tr class="row">
                  <th scope="col" class="col-md-2">Actions</th>
                  <th scope="col" class="col-md-10">Name</th>
                </tr>
              </thead>
              <paginate name="servers" v-if="servers.length" :list="servers" :per="10" tag="tbody">
                <tr v-for="(server, index) in paginated('servers')" :key="index" class="row">
                  <td class="col-md-2">
                    <button class="btn btn-sm btn-warning">
                      <i class="material-icons md-16" @click.prevent="update(server, index)">edit</i>
                    </button>
                    <button
                      class="btn btn-sm btn-danger"
                      @click.prevent="destroy(server.id, index)"
                    >
                      <i class="material-icons md-16">delete</i>
                    </button>
                  </td>
                  <td class="col-md-10">{{server.name}}</td>
                </tr>
              </paginate>
              <paginate-links
                for="servers"
                :async="true"
                :hide-single-page="true"
                :limit="5"
                :show-step-links="true"
                :classes="{
                  'ul': 'pagination', 
                  'li': 'page-item', 
                  'a': 'page-link',
                  '.next > a': 'next-link',
                  '.prev > a': 'prev-link'}"
                class="float-right"
              ></paginate-links>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { notifications } from "../mixins/notifications";

export default {
  data() {
    return {
      form: {
        name: "",
        id: ""
      },
      servers: [],
      paginate: ["servers"],
      edit: false,
      editing: {
        server: "",
        index: ""
      }
    };
  },
  async mounted() {
    let response = await axios.get(url + "/admin/servers/data");
    this.servers = response.data;
  },
  methods: {
    // create a new server in database
    async store() {
      try {
        let response = await axios.post(
          url + "/admin/servers/store",
          this.form
        );
        this.servers.unshift(response.data.body);
        this.form.name = "";
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // delete a server from database
    destroy(id, index) {
      this.showConfirm(async () => {
        try {
          let response = await axios.delete(
            url + "/admin/servers/destroy/" + id
          );
          this.servers.splice(index, 1);
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError();
        }
      });
    },
    update(server, index) {
      this.form.name = server.name;
      this.edit = true;
      this.editing.server = server;
      this.editing.index = index;
    },
    // update a server from database
    async updateSubmit() {
      try {
        this.form.id = this.editing.server.id;
        let response = await axios.put(
          url + "/admin/servers/update/" + this.editing.server.id,
          this.form
        );
        this.servers[this.editing.index] = response.data.body;
        this.paginate.servers.list[this.editing.index] = response.data.body;
        this.form.name = "";
        this.edit = false;
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    cancel() {
      this.edit = false;
      this.form.name = "";
    }
  },
  mixins: [notifications]
};
</script>


<style scoped>
.table {
  min-height: 600px;
}
</style>