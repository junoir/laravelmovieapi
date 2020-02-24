<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-sm-6">
                <h3 class="card-title">Series</h3>
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

            <!--  Series Index-->

            <table v-if="index" class="table table-hover">
              <thead>
                <tr class="row">
                  <th class="col-md-2">Actions</th>
                  <th class="col-md-2">Tmdb ID</th>
                  <th class="col-md-2">Poster</th>
                  <th class="col-md-6">Name</th>
                </tr>
              </thead>
              <paginate
                v-if="filteredSeries.length"
                name="filteredSeries"
                :list="filteredSeries"
                :per="5"
                tag="tbody"
              >
                <tr v-for="(serie, index) in paginated('filteredSeries')" :key="index" class="row">
                  <td class="col-md-2">
                    <button class="btn btn-sm btn-warning" @click="editing(serie)">
                      <i class="material-icons md-16">edit</i>
                    </button>
                    <button class="btn btn-sm btn-danger" @click="destroy(serie.id, index)">
                      <i class="material-icons md-16">delete</i>
                    </button>
                  </td>
                  <td class="col-md-2">{{serie.tmdb_id}}</td>
                  <td class="col-md-2">
                    <img :src="serie.poster_path" height="80" />
                  </td>
                  <td class="col-md-6">{{serie.name}}</td>
                </tr>
              </paginate>
              <paginate-links
                v-if="filteredSeries.length"
                for="filteredSeries"
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

            <!-- Serie Create -->
            <section v-if="add || edit">
              <div class="col-md-12">
                <div class="input-group">
                  <input
                    type="text"
                    v-model="tmdb"
                    class="form-control"
                    placeholder="themoviedb.org ID here. Example: 48866"
                  />&nbsp;
                  <button
                    type="submit"
                    :disabled="!settings.tmdb_api_key || !tmdb || isNaN(tmdb)"
                    class="btn btn-primary"
                    @click="getSerie()"
                  >
                    <i class="material-icons md-16">search</i>
                  </button>
                </div>

                <form class="mt-1" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="boxposter mx-auto">
                          <img
                            v-if="form.serie.poster_path"
                            class="poster"
                            :src="form.serie.poster_path"
                          />
                        </div>
                        <label for="poster_path">Poster</label>
                        <input
                          id="poster_path"
                          name="poster_path"
                          v-model="form.serie.poster_path"
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
                              >{{(poster.length) ? poster.name : 'Choose poster'}}</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="boxbackdrop mx-auto">
                        <img
                          v-if="form.serie.backdrop_path"
                          class="backdrop"
                          :src="form.serie.backdrop_path"
                        />
                      </div>
                      <label for="backdrop_path">Backdrop</label>
                      <input
                        id="backdrop_path"
                        name="backdrop_path"
                        v-model="form.serie.backdrop_path"
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
                            >{{(backdrop.length) ? backdrop.name : 'Choose backdrop'}}</label>
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
                          :src="form.serie.preview_path"
                          allowfullscreen
                        ></iframe>
                      </div>
                      <label for="preview_path">Preview</label>
                      <input
                        id="preview_path"
                        name="preview_path"
                        v-model="form.serie.preview_path"
                        type="text"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="name">Serie</label>
                        <input
                          v-model="form.serie.name"
                          id="name"
                          type="text"
                          class="form-control"
                          required
                        />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="first_air_date">First air date</label>
                        <input
                          v-model="form.serie.first_air_date"
                          id="first_air_date"
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
                          v-model="form.serie.overview"
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
                          v-model="form.serie.vote_average"
                          id="vote_average"
                          type="number"
                          class="form-control"
                          required
                        />
                      </div>
                      <div class="form-group">
                        <label for="vote_count">Votes</label>
                        <input
                          v-model="form.serie.vote_count"
                          id="vote_count"
                          type="number"
                          class="form-control"
                          required
                        />
                      </div>
                      <div class="form-group">
                        <label for="popularity">Popularity</label>
                        <input
                          v-model="form.serie.popularity"
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
                          v-model="form.serie.genres"
                          :options="options"
                          :value="form.serie.genres"
                          :multiple="true"
                          :close-on-select="false"
                          :clear-on-select="false"
                          :preserve-search="true"
                          placeholder="Choose genres"
                          label="name"
                          track-by="name"
                          @remove="destroyGenre"
                        ></multiselect>
                      </div>
                    </div>
                  </div>
                  <hr />

                  <!-- Seasons, Episodes and Videos -->

                  <div class="row">
                    <div class="col-md-6">
                      <div class="input-group">
                        <input
                          v-model="addseason"
                          type="text"
                          class="form-control input"
                          placeholder="Season number"
                        />
                        <div class="input-group-btn">
                          <button
                            type="submit"
                            @click.prevent="getSeason()"
                            class="btn btn-primary ml-2"
                          >
                            <i class="material-icons md-16">autorenew</i>Add from TMDB
                          </button>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="season">Season</label>
                        <multiselect
                          v-model="season"
                          deselect-label="Can't remove this value"
                          track-by="season_number"
                          label="season_number"
                          placeholder="Select season"
                          :options="form.serie.seasons"
                          :searchable="true"
                          :allow-empty="false"
                          @select="selectSeason"
                        >
                          <template slot="singleLabel" slot-scope="props">
                            <img
                              class="option__image"
                              :src="props.option.poster_path"
                              :alt="props.option.season_number"
                              height="90"
                            />
                            <span class="option__title ml-1">{{ props.option.name }}</span>
                          </template>
                        </multiselect>
                      </div>

                      <div
                        class="form-group"
                        v-if="selectedSeason >= 0 && form.serie.seasons[selectedSeason]"
                      >
                        <label for="seasonoverview">Season Overview</label>
                        <textarea
                          id="seasonoverview"
                          v-model="form.serie.seasons[selectedSeason].overview"
                          class="form-control"
                          required
                        ></textarea>
                      </div>

                      <div class="input-group" v-if="selectedSeason >= 0">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                          <input
                            @change="storePosterSeason()"
                            type="file"
                            class="custom-file-input"
                            id="posterSeason"
                          />
                          <label
                            class="custom-file-label"
                            for="posterSeason"
                          >{{(posterSeason.length) ? posterSeason.name : 'Choose poster season'}}</label>
                        </div>
                      </div>

                      <div v-if="selectedSeason >= 0" class="float-right my-2">
                        <button @click="destroySeason()" type="button" class="btn btn-danger ml-2">
                          <i class="material-icons md-16">delete</i>Delete
                        </button>
                      </div>
                    </div>

                    <template v-if="selectedSeason >= 0">
                      <div class="col-md-6">
                        <div class="input-group">
                          <input
                            v-model="addepisode"
                            type="text"
                            class="form-control input"
                            placeholder="Episode number"
                          />
                          <div class="input-group-btn">
                            <button
                              type="submit"
                              @click.prevent="getEpisode"
                              class="btn btn-primary ml-2"
                            >
                              <i class="material-icons md-16">autorenew</i>Add from TMDB
                            </button>
                          </div>
                        </div>

                        <div class="form-group" v-if="selectedSeason >= 0">
                          <label for="episode">Episode</label>
                          <multiselect
                            v-model="episode"
                            deselect-label="Can't remove this value"
                            track-by="episode_number"
                            label="episode_number"
                            placeholder="Select episode"
                            :options="form.serie.seasons[selectedSeason].episodes"
                            :searchable="true"
                            :allow-empty="false"
                            @select="selectEpisode"
                          >
                            <template slot="singleLabel" slot-scope="{ option }">
                              <img
                                class="option__image"
                                :src="option.still_path"
                                :alt="option.episode_number"
                                height="90"
                              />
                              <strong>{{ option.episode_number }}</strong>:
                              <strong>{{ option.name }}</strong>
                            </template>
                          </multiselect>
                        </div>

                        <div
                          class="form-group"
                          v-if="selectedEpisode >= 0 && form.serie.seasons[selectedSeason].episodes[selectedEpisode]"
                        >
                          <label for="seasonoverview">Episode Overview</label>
                          <textarea
                            id="seasonoverview"
                            v-model="form.serie.seasons[selectedSeason].episodes[selectedEpisode].overview"
                            class="form-control"
                            required
                          ></textarea>
                        </div>

                        <div class="input-group" v-if="selectedEpisode >= 0">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                          </div>
                          <div class="custom-file">
                            <input
                              @change="storeStillEpisode"
                              type="file"
                              class="custom-file-input"
                              id="stillEpisode"
                            />
                            <label
                              class="custom-file-label"
                              for="stillEpisode"
                            >{{(stillEpisode.length) ? stillEpisode.name : 'Choose still episode'}}</label>
                          </div>
                        </div>

                        <div v-if="selectedEpisode >= 0" class="float-right my-2">
                          <button
                            @click="destroyEpisode()"
                            type="button"
                            class="btn btn-danger ml-2"
                          >
                            <i class="material-icons md-16">delete</i>Delete
                          </button>
                        </div>
                      </div>
                    </template>
                  </div>

                  <hr />
                  <section v-if="selectedEpisode >= 0">
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
                            <input
                              v-model="hd"
                              type="checkbox"
                              class="custom-control-input"
                              id="hd"
                            />
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
                        <tr
                          v-for="(item, index) in form.serie.seasons[selectedSeason].episodes[selectedEpisode].videos"
                          :key="index"
                          class="row"
                        >
                          <td class="col-md-2">
                            <button
                              class="btn btn-sm btn-danger"
                              @click.prevent="deleteLink(item, index)"
                            >
                              <i class="material-icons md-16">delete</i>
                            </button>
                          </td>
                          <td class="col-md-1">{{item.lang}}</td>
                          <td class="col-md-2">{{item.server}}</td>
                          <td class="col-md-6">{{item.link}}</td>
                          <td class="col-md-1">{{item.hd ? 'true' : 'false'}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </section>

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
import { settings } from "../mixins/settings";
import { setTimeout } from "timers";

export default {
  data() {
    return {
      index: true,
      add: false,
      edit: false,
      series: [],
      paginate: ["series", "filteredSeries"],
      tmdb: null,
      form: {
        serie: {
          backdrop_path: "",
          poster_path: "",
          preview_path: "",
          genres: [],
          seasons: [{ episodes: [{ videos: [] }] }]
        },
        notification: false
      },
      poster: "",
      backdrop: "",
      posterSeason: "",
      stillEpisode: "",
      search: "",
      servers: [],
      server: "",
      season: null,
      selectedSeason: -1,
      oldSeason: {},
      episode: null,
      selectedEpisode: -1,
      hd: false,
      link: "",
      options: [],
      addseason: "",
      addepisode: "",
      video: null,
      loading: false
    };
  },
  async mounted() {
    let response = await axios.get(url + "/admin/series/data");
    this.series = response.data;
    response = await axios.get(url + "/admin/servers/data");
    this.servers = response.data;
    response = await axios.get(url + "/admin/genres/data");
    this.options = response.data;
  },
  methods: {
    create() {
      this.index = false;
      this.edit = false;
      this.add = true;
    },
    back() {
      this.form.serie = {
        backdrop_path: "",
        poster_path: "",
        preview_path: "",
        genres: [],
        seasons: [{ episodes: [{ videos: [] }] }]
      };
      this.link = "";
      this.server = "";
      this.video = null;
      this.tmdb = null;
      this.add = false;
      this.edit = false;
      this.index = true;
    },
    editing(serie) {
      this.index = false;
      this.add = false;
      this.edit = true;
      this.form.serie = serie;
      this.tmdb = serie.tmdb_id;
    },
    // Get a serie from themoviedb, including seasons and episodes.
    async getSerie() {
      let serie = "";
      let oldSerie = this.form.serie;
      let oldSeason = "";
      let oldEpisode = "";

      try {
        let response = await http.get(
          "https://api.themoviedb.org/3/tv/" +
            this.tmdb +
            "?api_key=" +
            this.settings.tmdb_api_key +
            "&language=" +
            this.settings.tmdb_lang.iso_639_1 +
            "&append_to_response=videos"
        );

        serie = _.mapKeys(response.data, function(value, key) {
          return key == "id" ? "tmdb_id" : key;
        });

        if (this.edit) {
          serie.id = oldSerie.id;
        }

        if (typeof serie.videos.results[0] !== "undefined") {
          serie.preview_path =
            "https://www.youtube.com/embed/" + serie.videos.results[0].key;
        } else if (this.edit && oldSerie.preview_path) {
          serie.preview_path = oldSerie.preview_path;
        } else {
          response = await http.get(
            "https://api.themoviedb.org/3/tv/" +
              this.tmdb +
              "/videos?api_key=" +
              this.settings.tmdb_api_key
          );
          if (response.data.results[0]) {
            serie.preview_path =
              "https://www.youtube.com/embed/" + response.data.results[0].key;
          }
        }

        if(serie.poster_path){
          serie.poster_path = 
          "https://image.tmdb.org/t/p/w500" + serie.poster_path;
        }
        if(serie.backdrop_path){
          serie.backdrop_path = 
          "https://image.tmdb.org/t/p/w780" + serie.backdrop_path;
        }

        for (const [index, season] of serie.seasons.entries()) {
          serie.seasons[index] = _.mapKeys(season, function(value, key) {
            return key == "id" ? "tmdb_id" : key;
          });

          if (this.edit) {
            oldSeason = oldSerie.seasons.find(
              s => s.season_number === season.season_number
            );

            if (typeof oldSeason !== "undefined") {
              serie.seasons[index].id = oldSeason.id;
              serie.seasons[index].serie_id = oldSeason.serie_id;
            }
          }

          if (serie.seasons[index].poster_path) {
            serie.seasons[index].poster_path =
              "https://image.tmdb.org/t/p/w500" +
              serie.seasons[index].poster_path;
          }

          let episodes = [];
          response = await http.get(
            "https://api.themoviedb.org/3/tv/" +
              this.tmdb +
              "/season/" +
              season.season_number +
              "?api_key=" +
              this.settings.tmdb_api_key +
              "&language=" +
              this.settings.tmdb_lang.iso_639_1
          );

          for (let episode of response.data.episodes) {
            episode = _.mapKeys(episode, function(value, key) {
              return key == "id" ? "tmdb_id" : key;
            });

            if (episode.still_path) {
              episode.still_path =
                "https://image.tmdb.org/t/p/w185" + episode.still_path;
            }

            if (this.edit && typeof oldSeason !== "undefined") {
              oldEpisode = oldSeason.episodes.find(
                e => e.tmdb_id === episode.tmdb_id
              );
              if (typeof oldEpisode !== "undefined") {
                episode.id = oldEpisode.id;
                episode.season_id = oldEpisode.season_id;
                episode.videos = oldEpisode.videos;
              }
            }
            episodes.push(episode);
          }
          serie.seasons[index].episodes = episodes;
        }

        this.form.serie = serie;
      } catch (error) {
        this.showError();
      }
    },
    // create a new serie in database
    async store() {
      try {
        let response = await axios.post(url + "/admin/series/store", this.form);

        this.add = false;
        this.edit = false;
        this.index = true;
        this.form.serie = {
          backdrop_path: "",
          poster_path: "",
          preview_path: "",
          genres: [],
          seasons: [{ episodes: [{ videos: [] }] }]
        };
        this.tmdb = null;
        this.selectedSeason = -1;
        this.selectedEpisode = -1;
        this.season = null;
        this.episode = null;
        this.link = "";
        this.server = "";
        this.video = null;
        this.series.unshift(response.data.body);
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // update a serie from database
    async update() {
      try {
        let response = await axios.put(
          url + "/admin/series/update/" + this.form.serie.id,
          this.form
        );

        this.add = false;
        this.edit = false;
        this.index = true;
        this.form.serie = {
          backdrop_path: "",
          poster_path: "",
          preview_path: "",
          genres: [],
          seasons: [{ episodes: [{ videos: [] }] }]
        };
        this.tmdb = null;
        this.selectedSeason = -1;
        this.selectedEpisode = -1;
        this.season = null;
        this.episode = null;
        this.link = "";
        this.server = "";
        this.video = null;
        this.showSuccess(response.data.message);
        this.series = response.data.body;
      } catch (error) {
        this.showError(error.response);
      }
    },
    // delete a serie from database
    destroy(id, index) {
      this.showConfirm(async () => {
        try {
          let response = await axios.delete(
            url + "/admin/series/destroy/" + id
          );
          let serieIndex = this.series.findIndex(serie => serie.id === id);
          this.series.splice(serieIndex, 1);
          this.paginate.filteredSeries.list.splice(index, 1);
          this.selectedSeason = -1;
          this.selectedEpisode = -1;
          this.season = null;
          this.episode = null;
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError();
        }
      });
    },
    // store a new poster in storage
    async storePoster(event) {
      try {
        this.poster = event.target.files[0];
        let data = new FormData();
        data.append("image", this.poster);

        let response = await axios.post(
          url + "/admin/series/image/store",
          data
        );

        this.form.serie.poster_path = response.data.image_path;
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // store a new poster for season in storage
    async storePosterSeason(event) {
      try {
        this.posterSeason = event.target.files[0];
        let data = new FormData();
        data.append("image", this.posterSeason);

        let response = await axios.post(
          url + "/admin/series/image/store",
          data
        );

        this.form.serie.seasons[this.selectedSeason].poster_path =
          response.data.image_path;
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // storage new still episode in storage
    async storeStillEpisode(event) {
      try {
        this.stillEpisode = event.target.files[0];
        let data = new FormData();
        data.append("image", this.stillEpisode);

        let response = await axios.post(
          url + "/admin/series/image/store",
          data
        );

        this.form.serie.seasons[this.selectedSeason].episodes[
          this.selectedEpisode
        ].still_path = response.data.image_path;
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // storage new backdrop in storage
    async storeBackdrop(event) {
      try {
        this.backdrop = event.target.files[0];
        let data = new FormData();
        data.append("image", this.backdrop);

        let response = await axios.post(
          url + "/admin/series/image/store",
          data
        );

        this.form.serie.backdrop_path = response.data.image_path;
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
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
          let response = await axios.post(url + "/admin/video/store", data);
          this.link = response.data.video_path;
          this.server = { name: response.data.server };
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError(error.response);
        } finally {
          this.loading = false;
        }
      }
    },
    // add a video link to an episode
    addLink() {
      if (
        this.selectedServer === "" ||
        this.link === "" ||
        this.form.serie === ""
      ) {
        return;
      }
      let episode = this.form.serie.seasons[this.selectedSeason].episodes[
        this.selectedEpisode
      ];

      if (!episode.videos) {
        Vue.set(episode, "videos", []);
      }

      episode.videos.unshift({
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
    // delete a video link from an episode
    deleteLink(link, index) {
      this.showConfirm(async () => {
        try {
          if (link.id) {
            let response = await axios.delete(
              url + "/admin/series/videos/destroy/" + link.id
            );

            this.showSuccess(response.data.message);
          }
          this.form.serie.seasons[this.selectedSeason].episodes[
            this.selectedEpisode
          ].videos.splice(index, 1);
        } catch (error) {
          this.showError();
        }
      });
    },
    // assign the index of the selected season
    selectSeason(event) {
      this.selectedSeason = this.form.serie.seasons.indexOf(event);
      this.episode = null;
      this.selectedEpisode = -1;
    },
    // assign the index of the selected episode
    selectEpisode(event) {
      this.selectedEpisode = this.form.serie.seasons[
        this.selectedSeason
      ].episodes.indexOf(event);
    },
    // delete a serie genre from the database
    async destroyGenre(event) {
      if (typeof event.genre !== "undefined") {
        try {
          let response = await axios.delete(
            url + "/admin/series/genres/destroy/" + event.id
          );
          this.showSuccess(response.data.message);
        } catch (error) {
          this.showError();
        }
      }
    },
    // get a new season from themoviedb
    async getSeason() {
      try {
        let response = await http.get(
          "https://api.themoviedb.org/3/tv/" +
            this.tmdb +
            "/season/" +
            this.addseason +
            "?api_key=" +
            this.settings.tmdb_api_key +
            "&language=" +
            this.settings.tmdb_lang.iso_639_1
        );

        response.data = _.mapKeys(response.data, function(value, key) {
          return key == "id" ? "tmdb_id" : key;
        });

        if (response.data.poster_path) {
          response.data.poster_path =
            "https://image.tmdb.org/t/p/w500" + response.data.poster_path;
        }

        for (const [
          indexEpisode,
          episode
        ] of response.data.episodes.entries()) {
          response.data.episodes[indexEpisode] = _.mapKeys(episode, function(
            value,
            key
          ) {
            return key == "id" ? "tmdb_id" : key;
          });

          if (episode.still_path) {
            response.data.episodes[indexEpisode].still_path =
              "https://image.tmdb.org/t/p/w185" + episode.still_path;
          }
        }

        let index = this.form.serie.seasons.findIndex(
          season => season.season_number === response.data.season_number
        );
        if (index < 0) {
          this.form.serie.seasons.push(response.data);
          this.showSuccess();
        } else {
          this.showError("this season already exists");
        }

        this.addseason = "";
      } catch (error) {
        this.showError();
      }
    },
    // delete a season from database
    destroySeason() {
      this.showConfirm(async () => {
        let season = this.form.serie.seasons[this.selectedSeason];
        if (season.id) {
          try {
            let response = await axios.delete(
              url + "/admin/series/seasons/destroy/" + season.id
            );
            this.showSuccess(response.data.message);
          } catch (error) {
            this.showError();
          }
        }
        this.form.serie.seasons.splice(this.selectedSeason, 1);
        this.season = null;
        this.episode = null;
        this.selectedSeason = -1;
        this.selectedEpisode = -1;
      });
    },
    // get a new episode from themoviedb
    async getEpisode() {
      try {
        let response = await http.get(
          "https://api.themoviedb.org/3/tv/" +
            this.tmdb +
            "/season/" +
            this.form.serie.seasons[this.selectedSeason].season_number +
            "/episode/" +
            this.addepisode +
            "?api_key=" +
            this.settings.tmdb_api_key
        );

        let index = this.form.serie.seasons[
          this.selectedSeason
        ].episodes.findIndex(
          episode => episode.episode_number === response.data.episode_number
        );
        if (index < 0) {
          let episode = _.mapKeys(response.data, function(value, key) {
            return key == "id" ? "tmdb_id" : key;
          });

          if (episode.still_path) {
            episode.still_path =
              "https://image.tmdb.org/t/p/w185" + episode.still_path;
          }
          this.form.serie.seasons[this.selectedSeason].episodes.push(episode);
          this.showSuccess();
        } else {
          this.showError("this episode already exists");
        }

        this.addepisode = "";
      } catch (error) {
        this.showError();
      }
    },
    // delete a episode from database
    destroyEpisode() {
      this.showConfirm(async () => {
        let episode = this.form.serie.seasons[this.selectedSeason].episodes[
          this.selectedEpisode
        ];
        if (episode.id) {
          try {
            let response = await axios.delete(
              url + "/admin/series/episodes/destroy/" + episode.id
            );
            this.showSuccess(response.data.message);
          } catch (error) {
            this.showError();
          }
        }
        this.form.serie.seasons[this.selectedSeason].episodes.splice(
          this.selectedEpisode,
          1
        );
        this.episode = null;
        this.selectedEpisode = -1;
      });
    }
  },
  computed: {
    // filter the series array with the search matches and return the filtered array
    filteredSeries() {
      return this.series.filter(serie => {
        return serie.name.toLowerCase().match(this.search.toLowerCase());
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

.season_poster {
  height: 120px;
}
</style>