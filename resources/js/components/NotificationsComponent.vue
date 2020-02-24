<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-5">
                <h4 class="card-title mb-0">Notifications</h4>
              </div>
            </div>
            <hr />
            <form>
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input v-model="title" type="text" id="title" class="form-control" />
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="content">Content</label>
                    <textarea v-model="body" id="content" cols="30" rows="10" class="form-control"></textarea>
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="image">Image</label>
                    <input
                      v-model="image"
                      type="text"
                      id="image"
                      class="form-control"
                      placeholder="URL link here (Optional)"
                    />
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-6">
                  <button
                    :disabled="!settings.authorization || !title || !body"
                    type="button"
                    class="btn btn-primary float-right"
                    @click.prevent="send()"
                  >
                    <i class="material-icons md-16">send</i> Push
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
import { settings } from "../mixins/settings";

export default {
  data() {
    return {
      title: "",
      body: "",
      image: ""
    };
  },
  mounted() {
    // check if the FCM server key exists in the settings
    setTimeout(() => {
      if (this.settings.authorization == null) {
        this.showAlert("you must configure your FCM server key in settings");
      }
    }, 1000);
  },
  methods: {
    // send a new push notification using the firebase rest service
    async send() {
      try {
        let config = {
          headers: {
            Authorization: "key=" + this.settings.authorization
          }
        };

        let form = {
          to: "/topics/all",
          notification: {
            title: this.title,
            body: this.body,
            image: this.image
          },
          data: { click_action: "FLUTTER_NOTIFICATION_CLICK" }
        };

        await http.post("https://fcm.googleapis.com/fcm/send", form, config);

        this.showSuccess();

        (this.title = ""), (this.body = ""), (this.image = "");
      } catch (error) {
        this.showError();
      }
    }
  },
  mixins: [notifications, settings]
};
</script>


<style scoped>
.table {
  min-height: 600px;
}
</style>