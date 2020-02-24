<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-5">
                <h4 class="card-title mb-0">Settings</h4>
              </div>
            </div>
            <hr />

            <div class="row">
              <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a
                      class="nav-link active"
                      id="brand-tab"
                      data-toggle="tab"
                      href="#brand"
                      role="tab"
                      aria-controls="brand"
                      aria-selected="true"
                    >Brand</a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      id="firebase-tab"
                      data-toggle="tab"
                      href="#firebase"
                      role="tab"
                      aria-controls="firebase"
                      aria-selected="false"
                    >Firebase</a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      id="admob-tab"
                      data-toggle="tab"
                      href="#admob"
                      role="tab"
                      aria-controls="admob"
                      aria-selected="false"
                    >Admob</a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      id="tmdb-tab"
                      data-toggle="tab"
                      href="#tmdb"
                      role="tab"
                      aria-controls="tmdb"
                      aria-selected="false"
                    >TheMovieDB</a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      id="aws-tab"
                      data-toggle="tab"
                      href="#aws"
                      role="tab"
                      aria-controls="aws"
                      aria-selected="false"
                    >Amazon Web Services</a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      id="skin-tab"
                      data-toggle="tab"
                      href="#skin"
                      role="tab"
                      aria-controls="skin"
                      aria-selected="false"
                    >Skin</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div
                    class="tab-pane fade show active"
                    id="brand"
                    role="tabpanel"
                    aria-labelledby="brand-tab"
                  >
                    <div class="row">
                      <div class="col-md-12"></div>
                    </div>
                    <div class="row">
                      <div class="col-md-8">
                        <div class="logo" v-if="logo">
                          <img :src="logo" />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="logo" v-if="miniLogo">
                          <img :src="miniLogo" />
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-8">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                          </div>
                          <div class="custom-file">
                            <input
                              @change="updateLogo"
                              type="file"
                              class="custom-file-input"
                              id="logo"
                            />
                            <label class="custom-file-label" for="logo">Choose logo</label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                          </div>
                          <div class="custom-file">
                            <input
                              @change="updateMiniLogo"
                              type="file"
                              class="custom-file-input"
                              id="miniLogo"
                            />
                            <label class="custom-file-label" for="miniLogo">Choose mini logo</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="app_name">App name</label>
                          <input
                            v-model="settings.app_name"
                            id="app_name"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="app_url_android">PlayStore URL</label>
                          <input
                            v-model="settings.app_url_android"
                            id="app_url_android"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="app_url_ios">AppStore URL</label>
                          <input
                            v-model="settings.app_url_ios"
                            id="app_url_ios"
                            type="text"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="firebase"
                    role="tabpanel"
                    aria-labelledby="firebase-tab"
                  >
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="authorization">FCM Server key</label>
                          <input
                            v-model="settings.authorization"
                            id="authorization"
                            type="text"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="admob" role="tabpanel" aria-labelledby="admob-tab">
                    <div class="row mb-2">
                      <div class="col-md-3">
                        <div class="form-check">
                          <div class="custom-control custom-switch ml-2">
                            <input
                              v-model="settings.ad_banner"
                              type="checkbox"
                              class="custom-control-input"
                              id="ad_banner"
                            />
                            <label class="custom-control-label" for="ad_banner">Ad banner</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check">
                          <div class="custom-control custom-switch ml-2">
                            <input
                              v-model="settings.ad_interstitial"
                              type="checkbox"
                              class="custom-control-input"
                              id="ad_interstitial"
                            />
                            <label
                              class="custom-control-label"
                              for="ad_interstitial"
                            >Ad interstitial</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="lead">Android</div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="ad_app_id">Ad App ID</label>
                          <input
                            v-model="settings.ad_app_id"
                            id="ad_app_id"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="ad_unit_id_banner">Ad unit banner ID</label>
                          <input
                            v-model="settings.ad_unit_id_banner"
                            id="ad_unit_id_banner"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="ad_unit_id_interstitial">Ad unit interstitial ID</label>
                          <input
                            v-model="settings.ad_unit_id_interstitial"
                            id="ad_unit_id_interstitial"
                            type="text"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>

                    <div class="lead">iOS</div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="ad_ios_app_id">Ad App ID</label>
                          <input
                            v-model="settings.ad_ios_app_id"
                            id="ad_ios_app_id"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="ad_ios_unit_id_banner">Ad unit banner ID</label>
                          <input
                            v-model="settings.ad_ios_unit_id_banner"
                            id="ad_ios_unit_id_banner"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="ad_ios_unit_id_interstitial">Ad unit interstitial ID</label>
                          <input
                            v-model="settings.ad_ios_unit_id_interstitial"
                            id="ad_ios_unit_id_interstitial"
                            type="text"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tmdb" role="tabpanel" aria-labelledby="tmdb-tab">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="tmdb_api_key">Api key</label>
                          <input
                            v-model="settings.tmdb_api_key"
                            id="tmdb_api_key"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="lang">Language</label>
                          <multiselect
                            :options="langs"
                            v-model="settings.tmdb_lang"
                            label="english_name"
                            track-by="iso_639_1"
                          ></multiselect>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="aws" role="tabpanel" aria-labelledby="aws-tab">
                    <div class="row mb-2">
                      <div class="col-md-3">
                        <div class="form-check">
                          <div class="custom-control custom-switch ml-2">
                            <input
                              v-model="settings.aws_s3_storage"
                              type="checkbox"
                              class="custom-control-input"
                              id="aws_s3_storage"
                            />
                            <label class="custom-control-label" for="aws_s3_storage">AWS S3 Storage</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="aws_access_key_id">AWS access key ID</label>
                          <input
                            v-model="settings.aws_access_key_id"
                            id="aws_access_key_id"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="aws_secret_access_key">AWS secret access key</label>
                          <input
                            v-model="settings.aws_secret_access_key"
                            id="aws_secret_access_key"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="aws_default_region">AWS default region</label>
                          <input
                            v-model="settings.aws_default_region"
                            id="aws_default_region"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="aws_bucket">AWS bucket</label>
                          <input
                            v-model="settings.aws_bucket"
                            id="aws_bucket"
                            type="text"
                            class="form-control"
                          />
                        </div>
                        
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="skin" role="tabpanel" aria-labelledby="skin-tab">
                    <div class="row mb-2">
                      <div class="col-md-3">
                        <div class="form-check">
                          <div class="custom-control custom-switch ml-2">
                            <input
                              v-model="settings.title_in_poster"
                              type="checkbox"
                              class="custom-control-input"
                              id="title_in_poster"
                            />
                            <label
                              class="custom-control-label"
                              for="title_in_poster"
                            >Title in poster</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check">
                          <div class="custom-control custom-switch ml-2">
                            <input
                              v-model="settings.livetv"
                              type="checkbox"
                              class="custom-control-input"
                              id="livetv"
                            />
                            <label class="custom-control-label" for="livetv">Live TV</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check">
                          <div class="custom-control custom-switch ml-2">
                            <input
                              v-model="settings.kids"
                              type="checkbox"
                              class="custom-control-input"
                              id="kids"
                            />
                            <label class="custom-control-label" for="kids">Kids</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-check">
                          <div class="custom-control custom-switch ml-2">
                            <input
                              v-model="settings.app_color_dark"
                              type="checkbox"
                              class="custom-control-input"
                              id="app_color_dark"
                            />
                            <label class="custom-control-label" for="app_color_dark">Color dark</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-check">
                          <div class="custom-control custom-switch ml-2">
                            <input
                              v-model="settings.app_bar_animation"
                              type="checkbox"
                              class="custom-control-input"
                              id="app_bar_animation"
                            />
                            <label
                              class="custom-control-label"
                              for="app_bar_animation"
                            >Appbar animation</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="app_background_color">Background Color</label>
                          <input
                            v-model="settings.app_background_color"
                            name="app_background_color"
                            type="color"
                            id="app_background_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="app_primary_color">Primary Color</label>
                          <input
                            v-model="settings.app_primary_color"
                            name="app_primary_color"
                            type="color"
                            id="app_primary_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="app_buttons_color">Buttons Color</label>
                          <input
                            v-model="settings.app_buttons_color"
                            name="app_buttons_color"
                            type="color"
                            id="app_buttons_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="app_bar_color">Appbar Color</label>
                          <input
                            v-model="settings.app_bar_color"
                            name="app_bar_color"
                            type="color"
                            id="app_bar_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="app_bar_icons_color">Appbar Icons Color</label>
                          <input
                            v-model="settings.app_bar_icons_color"
                            name="app_bar_icons_color"
                            type="color"
                            id="app_bar_icons_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="bottom_navigation_bar_color">Bottom Navigation Bar Color</label>
                          <input
                            v-model="settings.bottom_navigation_bar_color"
                            name="bottom_navigation_bar_color"
                            type="color"
                            id="bottom_navigation_bar_color"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="app_header_recent_task_color">Header recent task Color</label>
                          <input
                            v-model="settings.app_header_recent_task_color"
                            name="app_header_recent_task_color"
                            type="color"
                            id="app_header_recent_task_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="app_splash_color">Splash Color</label>
                          <input
                            v-model="settings.app_splash_color"
                            name="app_splash_color"
                            type="color"
                            id="app_splash_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="icons_color">Icons Color</label>
                          <input
                            v-model="settings.icons_color"
                            name="icons_color"
                            type="color"
                            id="icons_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label
                            for="app_bar_opacity"
                          >Appbar Opacity: {{Math.round(settings.app_bar_opacity * 100)}} %</label>
                          <input
                            v-model="settings.app_bar_opacity"
                            name="app_bar_opacity"
                            type="range"
                            id="app_bar_opacity"
                            class="form-control"
                            max="1.00"
                            min="0.00"
                            step="0.01"
                          />
                        </div>
                        <div class="form-group">
                          <label for="app_bar_title_color">Appbar Title Color</label>
                          <input
                            v-model="settings.app_bar_title_color"
                            name="app_bar_title_color"
                            type="color"
                            id="app_bar_title_color"
                            class="form-control"
                          />
                        </div>
                        <div class="form-group">
                          <label for="text_color">Text Color</label>
                          <input
                            v-model="settings.text_color"
                            name="text_color"
                            type="color"
                            id="text_color"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-auto ml-auto">
                <button type="submit" class="btn btn-primary" @click.prevent="update()">
                  <i class="material-icons md-16">update</i> Update
                </button>
              </div>
            </div>
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
      logo: url+"/api/image/logo",
      miniLogo: url+"/api/image/minilogo"
    };
  },
  methods: {
    // update the settings in the database
    async update() {
      try {
        let response = await axios.put(
          url+"/admin/settings/update/" + this.settings.id,
          this.settings
        );
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // update the logo in the storage
    async updateLogo(event) {
      try {
        let data = new FormData();
        data.append("image", event.target.files[0]);

        let response = await axios.post(url+"/admin/update/logo", data);
        this.logo = response.data.image_path;
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    },
    // update the mini logo in the storage
    async updateMiniLogo(event) {
      try {
        let data = new FormData();
        data.append("image", event.target.files[0]);

        let response = await axios.post(url+"/admin/update/minilogo", data);
        this.miniLogo = response.data.image_path;
        this.showSuccess(response.data.message);
      } catch (error) {
        this.showError(error.response);
      }
    }
  },
  mixins: [notifications, settings]
};
</script>

<style lang="scss">
.logo {
  max-width: 100%;
  img {
    max-height: 60px;
  }
}
</style>