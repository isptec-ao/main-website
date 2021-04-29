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
              employees: Object,
              filters: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Funcionários'
        },
        components: {
          Pagination,
          SearchFilter
        },
        data () {
            return {
                title: 'Funcionários',
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
              this.$inertia.replace(this.route('canvas.employees.index', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 150),
            deep: true,
          },
        },
        methods: {
          destroy(id) {
            if(confirm('tem a certeza?')) {
              this.$inertia.delete(this.route('canvas.employees.delete', id));
            }
          },
          restore(id) {
            if(confirm('tem a certeza?')) {
              this.$inertia.put(this.route('canvas.employees.restore', id));
            }
          },
          setTrans(id, lang) {
            
              this.$inertia.get(this.route('canvas.employees.getlang', {employee: id, lang: lang}));
          },
          reset() {
            this.form = mapValues(this.form, () => null)
          },
          togglenotification(employeeId) {
                this.$inertia.post(this.route('employees.togglenotification'), {id: employeeId});
                  
            }
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
          <h4 class="mb-0 font-size-18">Funcionários</h4>
          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.employees.create')" method="get">
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
            <!-- All Employees Table -->
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th>Nome Completo</th>
                    <th>Email</th>
                    <th>Gênero</th>
                    <th>Data de Nascimento</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="employee in $page.props.employees.data" :key="employee.id">
                    <td>{{ employee.full_name }}</td>
                    <td>{{ employee.email }}</td>
                    <td>
                      <span v-if="employee.gender==='M'">
                          <i class="bx bx-male text-primary"></i> M
                      </span>

                      <span v-else>
                          <i class="bx bx-female text-pink"></i> F
                      </span>
                    </td>
                    <td>{{ employee.dob }}</td>
                    <td>
                      <b-button-group class="btn-group-sm mt-0">
                          <inertia-link class="btn btn-secondary" :href="route('canvas.employees.edit', employee.id)" method="get">
                              <i class="bx bx-pencil align-middle"></i>
                          </inertia-link>
                          <b-button variant="secondary" @click="destroy(employee.id)">
                              <i class="bx bx-trash align-middle"></i>
                          </b-button>
                          <b-button variant="secondary" @click="restore(employee.id)">
                              <i class="bx bx-box align-middle"></i>
                          </b-button>
                          <b-button variant="brand" size="sm" v-if="employee.receive_bday_notification" v-b-tooltip.hover title="Desactivar Notificações!" @click="togglenotification(employee.id)">
                              <i class="bx bx-bell"></i>
                          </b-button>
                          <b-button v-else variant="danger" size="sm" v-b-tooltip.hover title="Activar Notificações!" @click="togglenotification(employee.id)">
                              <i class="bx bx-bell-off"></i>
                          </b-button>
                          <b-dropdown bottom size="sm">
                            <template v-slot:button-content>
                                <i class="bx bx-plus align-middle"></i> Traduções
                            </template>
                            <b-dropdown-item class="font-size-sm" v-for="lang in $page.props.locales" :key="lang" @click="setTrans(employee.id, lang)">
                            {{ lang.toUpperCase() }}
                            </b-dropdown-item>
                            
                        </b-dropdown>
                      </b-button-group>
                    </td>
                  </tr>
                  <tr v-if="$page.props.employees.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="5">No data found.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination :links="$page.props.employees.links" :lastpage="$page.props.employees.last_page" :firstpageurl="$page.props.employees.first_page_url" :lastpageurl="$page.props.employees.last_page_url" :nextpageurl="$page.props.employees.next_page_url" />
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
  </div>
</template>