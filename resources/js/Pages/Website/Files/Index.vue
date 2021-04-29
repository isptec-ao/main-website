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
              files: Object,
              filters: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Ficheiros'
        },
        components: {
          Pagination,
          SearchFilter
        },
        data () {
            return {
                title: 'Ficheiros',
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
              this.$inertia.replace(this.route('canvas.files.index', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 150),
            deep: true,
          },
        },
        methods: {
          destroy(id) {
            if(confirm('tem a certeza?')) {
              this.$inertia.delete(this.route('canvas.files.delete', id));
            }
          },
          restore(id) {
            if(confirm('tem a certeza?')) {
              this.$inertia.put(this.route('canvas.files.restore', id));
            }
          },
          setTrans(id, lang) {
            
              this.$inertia.get(this.route('canvas.files.getlang', {file: id, lang: lang}));
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
          <h4 class="mb-0 font-size-18">Ficheiros</h4>
          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.files.create')" method="get">
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
            <!-- All Celcatfiles Table -->
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Departmento</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="file in $page.props.files.data" :key="file.id">
                    <td>{{ file.name }}</td>
                    <td>{{ file.description }}</td>
                    <td>{{ file.category.name }}</td>
                    <td>{{ file.department.name }}</td>
                    <td>
                      <b-button-group class="btn-group-sm mt-0">
                          <inertia-link class="btn btn-secondary" :href="route('canvas.files.edit', file.id)" method="get">
                              <i class="bx bx-pencil align-middle"></i>
                          </inertia-link>
                          <b-button variant="secondary" @click="destroy(file.id)">
                              <i class="bx bx-trash align-middle"></i>
                          </b-button>
                          <b-button variant="secondary" @click="restore(file.id)">
                              <i class="bx bx-box align-middle"></i>
                          </b-button>
                          <b-dropdown bottom size="sm">
                            <template v-slot:button-content>
                                <i class="bx bx-plus align-middle"></i> Traduções
                            </template>
                            <b-dropdown-item class="font-size-sm" v-for="lang in $page.props.locales" :key="lang" @click="setTrans(file.id, lang)">
                            {{ lang.toUpperCase() }}
                            </b-dropdown-item>
                            
                        </b-dropdown>
                      </b-button-group>
                    </td>
                  </tr>
                  <tr v-if="$page.props.files.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="5">No data found.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination :links="$page.props.files.links" :lastpage="$page.props.files.last_page" :firstpageurl="$page.props.files.first_page_url" :lastpageurl="$page.props.files.last_page_url" :nextpageurl="$page.props.files.next_page_url" />
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
  </div>
</template>