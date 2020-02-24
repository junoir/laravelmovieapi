<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-sm-6">
                <h3 class="card-title">Live TV</h3>
              </div>

              <div class="col-md-6">
                <div class="row justify-content-end">
                  <div class="col-md-10">
                    <input
                      v-if="index"
                      type="text"
                      v-model="search"
                      placeholder="Search by name"
                      class="form-control"
                    />
                  </div>

                  <div class="col-md-2">
                    <button v-if="index" class="btn btn-primary" @click="create()">
                      <i class="material-icons md-16">add</i>
                    </button>

                    <button v-if="!index" class="btn btn-primary" @click="back()">
                      <i class="material-icons md-16">arrow_back</i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!--            Movie Index-->

            <table v-if="index" class="table table-hover">
              <thead>
                <tr class="row">
                  <th class="col-md-2">Actions</th>
                  <th class="col-md-2">Poster</th>
                  <th class="col-md-8">Name</th>
                </tr>
              </thead>
              <paginate
                v-if="filteredLivetvs.length"
                name="filteredLivetvs"
                :list="filteredLivetvs"
                :per="5"
                tag="tbody"
              >
                <tr
                  v-for="(livetv, index) in paginated('filteredLivetvs')"
                  :key="index"
                  class="row"
                >
                  <td class="col-md-2">
                    <button class="btn btn-sm btn-warning" @click="editing(livetv)">
                      <i class="material-icons md-16">edit</i>
                    </button>
                    <button class="btn btn-sm btn-danger" @click="destroy(livetv.id, index)">
                      <i class="material-icons md-16">delete</i>
                    </button>
                  </td>
                  <td class="col-md-2">
                    <img :src="livetv.poster_path" height="80" width="80" />
                  </td>
                  <td class="col-md-8">{{livetv.name}}</td>
                </tr>
              </paginate>
              <paginate-links
                v-if="filteredLivetvs.length"
                for="filteredLivetvs"
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

            <!-- livetv Create -->
            <section v-if="add || edit">
              <div class="col-md-12">
                <form class="mt-1" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="boxposter mx-auto">
                          <img
                            v-if="form.livetv.poster_path"
                            class="poster"
                            :src="form.livetv.poster_path"
                          />
                        </div>
                        <label for="poster_path">Poster</label>
                        <input
                          id="poster_path"
                          name="poster_path"
                          v-model="form.livetv.poster_path"
                          type="text"
                          class="form-control"
                          required
                        />
                        <div class="row mt-1">
                          <div class="input-group col-md-12">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                              <input
                                @change="storePoster"
                                type="file"
                                class="custom-file-input"
                                id="poster"
                              />
                              <label
                                class="custom-file-label"
                                for="poster"
                              >{{(poster) ? poster.name : 'Choose poster'}}</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="boxbackdrop mx-auto">
                        <img
                          v-if="form.livetv.backdrop_path"
                          class="backdrop"
                          :src="form.livetv.backdrop_path"
                        />
                      </div>
                      <label for="backdrop_path">Backdrop</label>
                      <input
                        id="backdrop_path"
                        name="backdrop_path"
                        v-model="form.livetv.backdrop_path"
                        type="text"
                        class="form-control"
                        required
                      />
                      <div class="row mt-1">
                        <div class="input-group col-md-12">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                          </div>
                          <div class="custom-file">
                            <input
                              @change="storeBackdrop"
                              type="file"
                              class="custom-file-input"
                              id="backdrop"
                            />
                            <label
                              class="custom-file-label"
                              for="backdrop"
                            >{{(backdrop) ? backdrop.name : 'Choose backdrop'}}</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="title">Name</label>
                        <input
                          v-model="form.livetv.name"
                          id="name"
                          type="text"
                          class="form-control"
                          required
                        />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="title">Overview</label>
                        <textarea
                          id="overview"
                          v-model="form.livetv.overview"
                          class="form-control pb-3"
                          required
                          rows="8"
                        ></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="title">Link</label>
                        <input
                          v-model="form.livetv.link"
                          id="link"
                          type="text"
                          class="form-control"
                          placeholder="HLS/M3U8/DASH/Embed here"
                          required
                        />
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-end">
                    <div v-if="add" class="col-auto ml-auto">
                      <div class="form-check form-check-inline float-right">
                        <label for="notification">Push notification</label>
                        <div class="custom-control custom-switch ml-3">
                          <input
                            v-model="form.notification"
                            type="checkbox"
                            class="custom-control-input"
                            id="notification"
                          />
                          <label class="custom-control-label" for="notification"></label>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <button
                        v-if="add"
                        type="submit"
                        class="btn btn-primary"
                        @click.prevent="store()"
                      >
                        <i class="material-icons md-16">save</i> Save
                      </button>
                      <button
                        v-if="edit"
                        type="submit"
                        class="btn btn-primary"
                        @click.prevent="update()"
                      >
                        <i class="material-icons md-16">update</i> Update
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <div></div>
            </section>
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
      index: true,
      add: false,
      edit: false,
      livetvs: [],
      paginate: ["livetvs", "filteredLivetvs"],
      form: {
        livetv: {
          name: "",
          overview: "",
          link: "",
          backdrop_path: "",
          poster_path: ""
        },
        notification: false
      },
      poster: null,
      backdrop: null,
      search: ""
    };
  },
  async mounted() {
    let response = await axios.get(url + "/admin/livetv/data");
    this.livetvs = response.data;
  },
  methods: {
    create() {
      this.index = false;
      this.edit = false;
      this.add = true;
    },
    back() {
      this.form.livetv = {
        name: "",
        overview: "",
        link: "",
        backdrop_path: "",
        poster_path: ""
      };
      this.add = false;
      this.edit = false;
      this.index = true;
    },
    editing(livetv) {
      this.index = false;
      this.add = false;
      this.edit = true;
      this.form.livetv = livetv;
    },
    // create a livetv in database
    async store() {
      try {
        let response = await axios.post(url + "/admin/livetv/store", this.form);

        this.add = false;
        this.edit = false;
        this.index = true;
        this.form.livetv = {
          name: "",
          overview: "",
          link: "",
          backdrop_path: "",
          poster_path: ""
        };
        this.poster = null;
        this.backdrop = null;
        this.livetvs.unshift(response.data.body);
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // update a livetv from database
    async update() {
      try {
        let response = await axios.put(
          url + "/admin/livetv/update/" + this.form.livetv.id,
          this.form
        );

        this.add = false;
        this.edit = false;
        this.index = true;
        this.form.livetv = {
          name: "",
          overview: "",
          link: "",
          backdrop_path: "",
          poster_path: ""
        };
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // delete a livetv from database
    destroy(id, index) {
      this.showConfirm(async () => {
        try {
          let response = await axios.delete(
            url + "/admin/livetv/destroy/" + id
          );
          let livetvIndex = this.livetvs.findIndex(livetv => livetv.id === id);
          this.livetvs.splice(livetvIndex, 1);
          this.paginate.filteredLivetvs.list.splice(index, 1);
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError();
        }
      });
    },
    // store a new poster in storage
    async storePoster(event) {
      if (typeof event.target.files[0] !== "undefined") {
        try {
          this.poster = event.target.files[0];
          let data = new FormData();
          data.append("image", this.poster);

          let response = await axios.post(
            url + "/admin/livetv/image/store",
            data
          );
          this.form.livetv.poster_path = response.data.image_path;
        } catch (error) {
          this.showError(error.response);
        }
      }
    },
    // store a new backdrop in storage
    async storeBackdrop(event) {
      if (typeof event.target.files[0] !== "undefined") {
        try {
          this.backdrop = event.target.files[0];
          let data = new FormData();
          data.append("image", this.backdrop);

          let response = await axios.post(
            url + "/admin/livetv/image/store",
            data
          );
          this.form.livetv.backdrop_path = response.data.image_path;
        } catch (error) {
          this.showError(error.response);
        }
      }
    }
  },
  computed: {
    // returns the livetv array filtered by the search
    filteredLivetvs() {
      return this.livetvs.filter(livetv => {
        return livetv.name.toLowerCase().match(this.search.toLowerCase());
      });
    }
  },
  mixins: [notifications]
};
</script>

<style scoped>
.poster {
  width: 138px;
}
.boxposter {
  border: 1px solid #ccc;
  width: 138px;
  height: 138px;
}

.backdrop {
  width: 230px;
  height: 138px;
}
.boxbackdrop {
  border: 1px solid #ccc;
  width: 230px;
  height: 138px;
}
iframe {
  border: 1px solid #ccc;
  width: 230px;
  height: 130px;
}

.table {
  min-height: 600px;
}

.table-links {
  min-height: 0px;
}
</style>