<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <div class="card text-white bg-primary">
          <div class="card-body pb-3">
            <button
              class="btn btn-transparent p-0 float-right"
              type="button"
              onclick="window.location.href='/admin/movies'"
            >
              <i class="material-icons md-14">settings</i>
            </button>
            <div class="text-value">{{movies.length}}</div>
            <div>Movies</div>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-md-4">
        <div class="card text-white bg-primary">
          <div class="card-body pb-3">
            <button
              class="btn btn-transparent p-0 float-right"
              type="button"
              onclick="window.location.href='/admin/series'"
            >
              <i class="material-icons md-14">settings</i>
            </button>
            <div class="text-value">{{series.length}}</div>
            <div>Series</div>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-md-4">
        <div class="card text-white bg-primary">
          <div class="card-body pb-3">
            <div class="btn-group float-right">
              <button
                class="btn btn-transparent p-0 float-right"
                type="button"
                onclick="window.location.href='/admin/livetv'"
              >
                <i class="material-icons md-14">settings</i>
              </button>
            </div>
            <div class="text-value">{{livetvs.length}}</div>
            <div>Live TV</div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row-->

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="lead">More Views</div>
            <hr>
            <div class="row">
              <div class="col-md-3">
                <span class="lead">Movies</span>
                <table class="table table-hover table-outline">
                  <thead class="thead-light">
                    <tr>
                      <th>Title</th>
                      <th>Views</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="movie in topmovies" :key="movie.id">
                      <td>{{movie.title}}</td>
                      <td>{{movie.views}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3">
                <span class="lead">Series Average</span>
                <table class="table table-hover table-outline">
                  <thead class="thead-light">
                    <tr>
                      <th>Name</th>
                      <th>Views</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="serie in topseries" :key="serie.id">
                      <td>{{serie.name}}</td>
                      <td>{{serie.views}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3">
                <span class="lead">Episodes</span>
                <table class="table table-hover table-outline">
                  <thead class="thead-light">
                    <tr>
                      <th>Name</th>
                      <th>Views</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="episode in topepisodes" :key="episode.id">
                      <td>{{episode.name}}</td>
                      <td>{{episode.views}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3">
                <span class="lead">Live TV</span>
                <table class="table table-hover table-outline">
                  <thead class="thead-light">
                    <tr>
                      <th>Name</th>
                      <th>Views</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="livetv in toplivetvs" :key="livetv.id">
                      <td>{{livetv.name}}</td>
                      <td>{{livetv.views}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col-->
    </div>
    <!-- /.row-->
  </div>
</template>

<script>
export default {
  data() {
    return {
      movies: [],
      series: [],
      livetvs: [],
      topepisodes: []
    };
  },
  async mounted() {
    let response = await axios.get(url+"/admin/movies/data");
      this.movies = response.data;
    response = await axios.get(url+"/admin/series/data");
      this.series = response.data; 
    response = await axios.get(url+"/admin/livetv/data");
      this.livetvs = response.data;
    response = await axios.get(url+"/admin/topepisodes");
      this.topepisodes = response.data;
  },
  computed: {
    topmovies() {
      return _.orderBy(this.movies, "views")
        .reverse()
        .splice(0, 10);
    },
    topseries() {
      return _.orderBy(this.series, "views")
        .reverse()
        .splice(0, 10);
    },
    toplivetvs() {
      return _.orderBy(this.livetvs, "views")
        .reverse()
        .splice(0, 10);
    }
  }
};
</script>
