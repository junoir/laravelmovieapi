<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-5">
                <h4 class="card-title mb-0">Account</h4>
              </div>
            </div>
            <hr />
            <div class="lead">Update Profile</div>
            <form>
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input v-model="user.name" type="text" id="name" class="form-control" />
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input v-model="user.email" type="email" id="email" class="form-control" />
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-6">
                  <button
                    :disabled="!user.name || !user.email"
                    type="button"
                    class="btn btn-primary float-right"
                    @click.prevent="update()"
                  >
                    <i class="material-icons md-16">update</i> Update
                  </button>
                </div>
              </div>
            </form>

            <hr />
            <div class="lead">Change Password</div>
            <form>
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input v-model="password" type="password" id="password" class="form-control" />
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password_confirmation">Repeat password</label>
                    <input
                      v-model="password_confirmation"
                      type="password"
                      id="password_confirmation"
                      class="form-control"
                    />
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-6">
                  <button
                    :disabled="password.length < 6 || password_confirmation.length < 6  || password !== password_confirmation"
                    type="button"
                    class="btn btn-primary float-right"
                    @click.prevent="change()"
                  >
                    <i class="material-icons md-16">update</i> Change
                  </button>
                </div>
              </div>
            </form>
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
      password: "",
      password_confirmation: "",
      user: {}
    };
  },
  async mounted() {
    try {
      let response = await axios.get("/admin/account/data");
      this.user = response.data;
    } catch (error) {
      this.showError();
    }
  },
  methods: {
    // update user data
    async update() {
      try {
        let response = await axios.put(url+"/admin/account/update", this.user);
        this.user = response.data.body;
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // update user password
    async change() {
      try {
        let response = await axios.put(url+"/admin/account/password/update", {
          password: this.password,
          password_confirmation: this.password_confirmation
        });
          this.password = "",
          this.password_confirmation = "",
          this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
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