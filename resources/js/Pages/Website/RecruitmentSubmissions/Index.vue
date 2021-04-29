<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    import mapValues from 'lodash/mapValues'
    import pickBy from 'lodash/pickBy'
    import throttle from 'lodash/throttle'
    import Pagination from '@/Shared/Pagination'
    import SearchFilter from '@/Shared/SearchFilter';
    export default {
        name: "Index",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              recruitmentsubmissions: Object,
              filters: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Recrutamento - Candidaturas'
        },
        components: {
          Pagination,
          SearchFilter
        },
        data () {
            return {
                title: 'Recrutamento - Candidaturas',
                form: {
                search: '',
                trashed: false,
                per_page: 5,
                range: null
              },
              perPage: [5,10, 25, 50, 100],
            }
        },
        watch: {
          form: {
            handler: throttle(function() {
              let query = pickBy(this.form)
              this.$inertia.replace(this.route('canvas.recruitmentsubmissions.index', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 150),
            deep: true,
          },
        },
        methods: {
          destroy(id) {
            if(confirm('tem a certeza?')) {
              this.$inertia.delete(this.route('canvas.recruitmentsubmissions.delete', id));
            }
          },
          restore(id) {
            if(confirm('tem a certeza?')) {
              this.$inertia.put(this.route('canvas.recruitmentsubmissions.restore', id));
            }
          },
          setTrans(id, lang) {
            
              this.$inertia.get(this.route('canvas.recruitmentsubmissions.getlang', {recruitmentsubmission: id, lang: lang}));
          },
          reset() {
            this.form = mapValues(this.form, () => null)
          },
        },
        computed: {

        },
        mounted() {

        },
    }
</script>
<template>
  <div>
      <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0 font-size-18">Recrutamento - Candidaturas</h4>
          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.recruitmentsubmissions.create')" method="get">
                    <i class="bx bx-folder-plus"></i>
                </inertia-link>
            </b-button-group>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row mt-4">

              <div class="col-sm-12 col-md-3 mt-2">
                <div id="analysistypes-table_length" class="dataTables_length">
                    <label class="d-inline-flex align-items-center">
                        Apresentar&nbsp;
                        <b-form-select v-model="form.per_page" size="sm" :options="perPage"></b-form-select>&nbsp;registos
                    </label>
                </div>
              </div>

              <div class="col-sm-12 col-md-3 mt-2">
                  <div id="analysistypes-table_filter_date" class="dataTables_filter text-md-right">
                  <date-picker input-class="form-control form-control-sm form-control"
                                v-model="form.range"
                                range
                                append-to-body
                                lang="pt"
                                valueType="format"
                                confirm>
                      <template slot="icon-calendar">
                          <i class="bx bx-calendar"></i>
                      </template>
                  </date-picker>
                  </div>
              </div>

              <div class="col-sm-12 col-md-3 mt-2">
                <div id="analysistypes-table_filter" class="dataTables_filter">
                  <b-input-group class="">
                      <template v-slot:prepend>
                          <b-button size="sm">
                              <i class="bx bx-search-alt-2"></i>
                          </b-button>
                      </template>
                      
                      <b-form-input
                        v-model="form.search"
                        type="search"
                        placeholder="Search..."
                        class="form-control form-control-sm"
                      ></b-form-input>
                    
                      <b-input-group-append>
                          <b-dropdown right size="sm" class="">
                              <template v-slot:button-content>
                                  <i class="bx bx-filter align-middle"></i> Filtrar
                              </template>
                              <b-dropdown-item class="font-size-sm" @click="form.trashed='only'">Apenas Removidos</b-dropdown-item>
                              <b-dropdown-item class="font-size-sm" @click="form.trashed='with'">Incl. Removidos </b-dropdown-item>
                              <b-dropdown-item class="font-size-sm" @click="reset">Limpar Filtro</b-dropdown-item>
                          </b-dropdown>
                      </b-input-group-append>
                  </b-input-group>
                </div>
              </div>
                
            <div class="col-sm-12 col-md-3 text-right mt-2">
                <div id="analysistypes-table_filter_options" class="dataTables_filter">
                    <b-dropdown right size="sm" class="btn-block">
                        <template v-slot:button-content>
                            <i class="bx bx-export align-middle"></i> Exportar
                        </template>
                        <b-dropdown-item class="font-size-sm">Excel</b-dropdown-item>
                        <b-dropdown-item class="font-size-sm">PDF</b-dropdown-item>
                        <b-dropdown-item class="font-size-sm">CSV</b-dropdown-item>
                    </b-dropdown>
                </div>
            </div>
            <!-- All Recruitmentsubmissions Table -->
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th>Publicação</th>
                    <th>Nome Completo</th>
                    <th>Gênero</th>
                    <th>Grau Académico</th>
                    <th>Experiência</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="recruitmentsubmission in $page.props.recruitmentsubmissions.data" :key="recruitmentsubmission.id">
                    <td>{{ recruitmentsubmission.publication.title }}</td>
                    <td>{{ recruitmentsubmission.full_name }}</td>
                    <td>{{ recruitmentsubmission.gender }}</td>
                    <td>{{ recruitmentsubmission.academic.name }}</td>
                    <td>{{ recruitmentsubmission.work_experience }}</td>
                    <td>
                      <b-button-group class="btn-group-sm mt-0">
                          <inertia-link class="btn btn-secondary" :href="route('canvas.recruitmentsubmissions.edit', recruitmentsubmission.id)" method="get">
                              <i class="bx bx-pencil align-middle"></i>
                          </inertia-link>
                          <b-button variant="secondary" @click="destroy(recruitmentsubmission.id)">
                              <i class="bx bx-trash align-middle"></i>
                          </b-button>
                          <b-button variant="secondary" @click="restore(recruitmentsubmission.id)">
                              <i class="bx bx-box align-middle"></i>
                          </b-button>
                          <b-dropdown bottom size="sm">
                            <template v-slot:button-content>
                                <i class="bx bx-plus align-middle"></i> Traduções
                            </template>
                            <b-dropdown-item class="font-size-sm" v-for="lang in $page.props.locales" :key="lang" @click="setTrans(recruitmentsubmission.id, lang)">
                            {{ lang.toUpperCase() }}
                            </b-dropdown-item>
                            
                        </b-dropdown>
                      </b-button-group>
                    </td>
                  </tr>
                  <tr v-if="$page.props.recruitmentsubmissions.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="5">No data found.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination :links="$page.props.recruitmentsubmissions.links" :lastpage="$page.props.recruitmentsubmissions.last_page" :firstpageurl="$page.props.recruitmentsubmissions.first_page_url" :lastpageurl="$page.props.recruitmentsubmissions.last_page_url" :nextpageurl="$page.props.recruitmentsubmissions.next_page_url" />
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
  </div>
</template>