<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-sm-6">
                <h3 class="card-title">Movies</h3>
              </div>

              <div class="col-md-6">
                <div class="row justify-content-end">
                  <div class="col-md-10">
                    <input
                      v-if="index"
                      type="text"
                      v-model="search"
                      placeholder="Search by title"
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

            <!-- Movies Index-->

            <table v-if="index" class="table table-hover">
              <thead>
                <tr class="row">
                  <th class="col-md-2">Actions</th>
                  <th class="col-md-2">Tmdb ID</th>
                  <th class="col-md-2">Poster</th>
                  <th class="col-md-6">Title</th>
                </tr>
              </thead>
              <paginate
                v-if="filteredMovies.length"
                name="filteredMovies"
                :list="filteredMovies"
                :per="5"
                tag="tbody"
              >
                <tr v-for="(movie, index) in paginated('filteredMovies')" :key="index" class="row">
                  <td class="col-md-2">
                    <button class="btn btn-sm btn-warning" @click="editing(movie)">
                      <i class="material-icons md-16">edit</i>
                    </button>
                    <button class="btn btn-sm btn-danger" @click="destroy(movie.id, index)">
                      <i class="material-icons md-16">delete</i>
                    </button>
                  </td>
                  <td class="col-md-2">{{movie.tmdb_id}}</td>
                  <td class="col-md-2">
                    <img :src="movie.poster_path" height="80" />
                  </td>
                  <td class="col-md-6">{{movie.title}}</td>
                </tr>
              </paginate>
              <paginate-links
                v-if="filteredMovies.length"
                for="filteredMovies"
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

            <!-- Movie Create -->
            <section v-if="add || edit">
              <div class="col-md-12">
                <div class="input-group">
                  <input
                    type="text"
                    v-model="tmdb"
                    class="form-control"
                    placeholder="themoviedb.org ID here. Example: 920"
                  />&nbsp;
                  <button
                    type="submit"
                    class="btn btn-primary"
                    @click="getMovie()"
                    :disabled="!settings.tmdb_api_key || !tmdb || isNaN(tmdb)"
                  >
                    <i class="material-icons md-16">search</i>
                  </button>
                </div>

                <form class="mt-2" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="boxposter mx-auto">
                          <img
                            v-if="form.movie.poster_path"
                            class="poster"
                            :src="form.movie.poster_path"
                          />
                        </div>
                        <label for="poster_path">Poster</label>
                        <input
                          id="poster_path"
                          name="poster_path"
                          v-model="form.movie.poster_path"
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
                    <div class="col-md-4">
                      <div class="boxbackdrop mx-auto">
                        <img
                          v-if="form.movie.backdrop_path"
                          class="backdrop"
                          :src="form.movie.backdrop_path"
                        />
                      </div>
                      <label for="backdrop_path">Backdrop</label>
                      <input
                        id="backdrop_path"
                        name="backdrop_path"
                        v-model="form.movie.backdrop_path"
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
                    <div class="col-md-4">
                      <div class="mx-auto text-center">
                        <iframe
                          frameborder="0"
                          scrolling="no"
                          width="230"
                          height="130"
                          type="text/html"
                          :src="form.movie.preview_path"
                          allowfullscreen
                        ></iframe>
                      </div>
                      <label for="preview_path">Preview</label>
                      <input
                        id="preview_path"
                        name="preview_path"
                        v-model="form.movie.preview_path"
                        type="text"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="title">Title</label>
                        <input
                          v-model="form.movie.title"
                          id="title"
                          type="text"
                          class="form-control"
                          required
                        />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="release_date">Release date</label>
                        <input
                          v-model="form.movie.release_date"
                          id="release_date"
                          type="date"
                          class="form-control"
                          required
                        />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="title">Overview</label>
                        <textarea
                          id="overview"
                          v-model="form.movie.overview"
                          class="form-control pb-3"
                          required
                          rows="8"
                        ></textarea>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="vote_average">Average</label>
                        <input
                          v-model="form.movie.vote_average"
                          id="vote_average"
                          type="number"
                          class="form-control"
                          required
                        />
                      </div>
                      <div class="form-group">
                        <label for="vote_count">Votes</label>
                        <input
                          v-model="form.movie.vote_count"
                          id="vote_count"
                          type="number"
                          class="form-control"
                          required
                        />
                      </div>
                      <div class="form-group">
                        <label for="popularity">Popularity</label>
                        <input
                          v-model="form.movie.popularity"
                          id="popularity"
                          type="number"
                          class="form-control"
                          required
                        />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div>
                        <multiselect
                          v-model="form.movie.genres"
                          :options="options"
                          :multiple="true"
                          :close-on-select="false"
                          :clear-on-select="false"
                          :preserve-search="true"
                          :hideSelected="true"
                          placeholder="Choose genres"
                          label="name"
                          track-by="name"
                          @remove="destroyGenre"
                        ></multiselect>
                      </div>
                    </div>
                  </div>

                  <hr />
                  <h3>Videos</h3>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="server">Server</label>
                        <multiselect
                          :options="servers"
                          v-model="server"
                          placeholder="Select one"
                          label="name"
                          track-by="id"
                        ></multiselect>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="lang">Language</label>
                        <multiselect
                          :options="langs"
                          v-model="lang"
                          placeholder="Select one (default ov)"
                          label="english_name"
                          track-by="iso_639_1"
                        ></multiselect>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-10">
                      <div class="form-group">
                        <label for="link">Link</label>
                        <input
                          type="text"
                          id="link"
                          v-model="link"
                          class="form-control"
                          placeholder="UPLOAD the video or enter a url HLS / M3U8 / MKV / MP4 / WEBM / OGV / FLV / EMBED / IFRAME"
                        />
                      </div>
                    </div>

                    <div class="col-md-1">
                      <div class="form-group">
                        <label for="hd">HD</label>
                        <div class="custom-control custom-switch">
                          <input v-model="hd" type="checkbox" class="custom-control-input" id="hd" />
                          <label class="custom-control-label" for="hd"></label>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-1 my-auto">
                      <button class="btn btn-primary float-right" @click.prevent="addLink()">
                        <i class="material-icons md-16">add</i>
                      </button>
                    </div>
                  </div>

                  <div class="row my-2">
                    <div class="col-md-12">
                      <div v-if="loading" class="d-flex justify-content-center">
                        <div class="spinner-border text-primary" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-2 mt-1">
                    <div class="input-group col-md-12">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Upload</span>
                      </div>
                      <div class="custom-file">
                        <input
                          @change="storeVideo"
                          type="file"
                          class="custom-file-input"
                          id="video"
                        />
                        <label
                          class="custom-file-label"
                          for="video"
                        >{{(video) ? video.name : 'Choose video'}}</label>
                      </div>
                    </div>
                  </div>

                  <table class="table table-striped table-links">
                    <thead>
                      <tr class="row">
                        <th scope="col" class="col-md-2">Actions</th>
                        <th scope="col" class="col-md-1">Lang</th>
                        <th scope="col" class="col-md-2">Server</th>
                        <th scope="col" class="col-md-6">Link</th>
                        <th scope="col" class="col-md-1">HD</th>
                      </tr>
                    </thead>
                    <tbody name="links">
                      <tr v-for="(item, index) in form.links" :key="index" class="row">
                        <td class="col-md-2">
                          <button
                            class="btn btn-sm btn-danger"
                            @click.prevent="destroyLink(item, index)"
                          >
                            <i class="material-icons md-16">clear</i>
                          </button>
                        </td>
                        <td class="col-md-1">{{item.lang}}</td>
                        <td class="col-md-2">{{item.server}}</td>
                        <td class="col-md-6">{{item.link}}</td>
                        <td class="col-md-1">{{(item.hd) ? 'true' : 'false'}}</td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="row">
                    <div class="col-auto ml-auto">
                      <div v-if="add" class="form-check form-check-inline">
                        <label for="notification">Push notification</label>
                        <div class="custom-control custom-switch ml-2">
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
                        type="button"
                        class="btn btn-primary float-right"
                        @click.prevent="store()"
                      >
                        <i class="material-icons md-16">save</i> Save
                      </button>

                      <button
                        v-if="edit"
                        type="button"
                        class="btn btn-primary float-right"
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
import { settings } from "../mixins/settings";
import { setTimeout } from "timers";

export default {
  data() {
    return {
      index: true,
      add: false,
      edit: false,
      tmdb: null,
      movies: [],
      paginate: ["filteredMovies"],
      form: {
        movie: {
          backdrop_path: "",
          poster_path: "",
          preview_path: "",
          genres: []
        },
        links: [],
        notification: false
      },
      poster: null,
      backdrop: null,
      video: null,
      search: "",
      servers: [],
      server: "",
      hd: false,
      link: "",
      options: [],
      loading: false
    };
  },
  async mounted() {
    let response = await axios.get(url+"/admin/movies/data");
    this.movies = response.data;
    response = await axios.get(url+"/admin/servers/data");
    this.servers = response.data;
    response = await axios.get(url+"/admin/genres/data");
    this.options = response.data;

    if (this.settings.tmdb_api_key == null) {
      this.showAlert("you must configure your TMDB api key in settings");
    }
  },
  methods: {
    // change the view to the create form
    create() {
      this.index = false;
      this.edit = false;
      this.add = true;
    },
    // change the view to the index
    back() {
      this.form.movie = "";
      this.form.links = [];
      this.tmdb = null;
      (this.server = ""),
        (this.link = ""),
        (this.video = null),
        (this.add = false);
      this.edit = false;
      this.index = true;
    },
    // change the view to the editing form
    editing(movie) {
      this.index = false;
      this.add = false;
      this.edit = true;
      this.form.movie = movie;
      this.tmdb = movie.tmdb_id;
      axios.get(url+"/api/movies/videos/" + movie.id).then(response => {
        this.form.links = response.data;
      });
    },
    // get the movie data from the tmdb api
    async getMovie() {
      let response = await http.get(
        "https://api.themoviedb.org/3/movie/" +
          this.tmdb +
          "?api_key=" +
          this.settings.tmdb_api_key +
          "&language=" +
          this.settings.tmdb_lang.iso_639_1 +
          "&append_to_response=videos"
      );

      let movie = _.mapKeys(response.data, function(value, key) {
        if (key == "id") {
          return "tmdb_id";
        }
        return key;
      });
      movie.id = this.form.movie.id;
      if (typeof movie.videos.results[0] !== "undefined") {
        movie.preview_path =
          "https://www.youtube.com/embed/" + movie.videos.results[0].key;
      } else if (this.edit && this.form.movie.preview_path) {
        movie.preview_path = this.form.movie.preview_path;
      } else {
        response = await http.get(
          "https://api.themoviedb.org/3/movie/" +
            this.tmdb +
            "/videos?api_key=" +
            this.settings.tmdb_api_key
        );
        if (response.data.results[0]) {
          movie.preview_path =
            "https://www.youtube.com/embed/" + response.data.results[0].key;
        }
      }
      if (movie.poster_path) {
        movie.poster_path =
          "https://image.tmdb.org/t/p/w500" + movie.poster_path;
      }
      if (movie.backdrop_path) {
        movie.backdrop_path =
          "https://image.tmdb.org/t/p/w780" + movie.backdrop_path;
      }

      this.form.movie = movie;
    },
    // create a new record (movie) in the database
    store() {
      axios
        .post(url+"/admin/movies/store", this.form)
        .then(response => {
          this.add = false;
          this.edit = false;
          this.index = true;
          this.form.movie = {};
          this.form.links = [];
          this.tmdb = null;
          this.link = "";
          this.server = "";
          this.video = null;
          this.movies.unshift(response.data.body);
          this.showSuccess(response.data.message);
        })
        .catch(error => {
          this.showError(error.response);
        });
    },
    // update a record (movie) in the database
    update() {
      axios
        .put(url+"/admin/movies/update/" + this.form.movie.id, this.form)
        .then(response => {
          this.add = false;
          this.edit = false;
          this.index = true;
          this.form.movie = {};
          this.form.links = [];
          this.tmdb = null;
          this.link = "";
          this.server = "";
          this.video = null;
          this.movies = response.data.body;
          this.showSuccess(response.data.message);
        })
        .catch(error => {
          this.showError(error.response);
        });
    },
    // delete a record (movie) in the databse
    destroy(id, index) {
      this.showConfirm(async () => {
        try {
          let response = await axios.delete(url+"/admin/movies/destroy/" + id);
          let movieIndex = this.movies.findIndex(movie => movie.id === id);
          this.movies.splice(movieIndex, 1);
          this.paginate.filteredMovies.list.splice(index, 1);
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError();
        }
      });
    },
    // save an image in storage and return the link
    async storePoster(event) {
      if (typeof event.target.files[0] !== "undefined") {
        try {
          this.poster = event.target.files[0];
          let data = new FormData();
          data.append("image", this.poster);

          let response = await axios.post(url+"/admin/movies/image/store", data);
          this.form.movie.poster_path = response.data.image_path;
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError(error.response);
        }
      }
    },
    // save an image in storage and return the link
    async storeBackdrop(event) {
      if (typeof event.target.files[0] !== "undefined") {
        try {
          this.backdrop = event.target.files[0];
          let data = new FormData();
          data.append("image", this.backdrop);

          let response = await axios.post(url+"/admin/movies/image/store", data);
          this.form.movie.backdrop_path = response.data.image_path;
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError(error.response);
        }
      }
    },
    // save an video in storage and return the link
    async storeVideo(event) {
      if (typeof event.target.files[0] !== "undefined") {
        try {
          this.loading = true;
          this.video = event.target.files[0];
          let data = new FormData();
          data.append("video", this.video);
          let response = await axios.post(url+"/admin/video/store", data);
          this.link = response.data.video_path;
          this.server = { name: response.data.server };
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError();
        } finally {
          this.loading = false;
        }
      }
    },
    // add a new link to the movie
    addLink() {
      if (this.server === "" || this.link === "" || this.form.movie === "")
        return;
      this.form.links.unshift({
        server: this.server.name,
        link: this.link,
        lang:
          this.lang.iso_639_1 && this.lang.iso_639_1 !== "xx"
            ? this.lang.iso_639_1
            : "ov",
        hd: this.hd
      });
      this.link = "";
      this.server = "";
      this.video = null;
    },
    // delete a link of the movie
    destroyLink(link, index) {
      this.showConfirm(() => {
        if (link.id) {
          axios
            .delete(url+"/admin/movies/videos/destroy/" + link.id)
            .then(response => {
              this.showSuccess(response.data.message);
            })
            .catch(error => {
              this.showError();
            });
        }
        this.form.links.splice(index, 1);
      });
    },
    // delete a genre of the movie
    destroyGenre(event) {
      if (event.genre !== undefined) {
        axios
          .delete(url+"/admin/movies/genres/destroy/" + event.id)
          .then(response => this.showSuccess(response.data.message))
          .catch(error => this.showError());
      }
    }
  },
  computed: {
    // filter the movies array with the search matches and return the filtered array
    filteredMovies() {
      return this.movies.filter(movie => {
        return movie.title.toLowerCase().match(this.search.toLowerCase());
      });
    }
  },
  mixins: [notifications, settings]
};
</script>

<style scoped>
.poster {
  width: 92px;
}
.boxposter {
  border: 1px solid #ccc;
  width: 92px;
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