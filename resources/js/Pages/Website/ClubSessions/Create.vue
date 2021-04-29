<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateClubSession",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Clube - Sessões'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            topic: null,
            description: null,
            venue: null,
            date: null,
            start_time: null,
            end_time: null,
            category_id: null
          }),
        }
        },
        methods: {
            
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
          <h4 class="mb-0 font-size-18">Clube - Sessões</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.clubsessions.index')" method="get">
                    <i class="bx bx-arrow-back"></i>
                </inertia-link>
            </b-button-group>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Adicionar</h4>

            <!-- Create Departments Form -->
            <b-form @submit.prevent="form.post('/canvas/clubsessions')">
              <slot />
              <b-form-group label="Clube" label-for="category_id">
              <multiselect
                  id="ajax"
                  v-model="form.category_id"
                  :options="$page.props.categories"
                  label="name"
                  track-by="id"
                  placeholder="Escreva para pesquisar"
                  open-direction="bottom"
                  deselect-label="Pressione Enter para excluir"
                  select-label="Pressione Enter para seleccionar"
                  selected-label="Seleccionado"
                  tag-placeholder="Pressione Enter para criar etiqueta"
              >
              <span slot="noOptions">A lista está vazia</span>
              </multiselect>
              <div v-if="form.errors.category_id" class="invalid-feedback animated fadeIn">{{form.errors.category_id}}</div>
              </b-form-group>
              <b-form-group label="Data" label-for="date">
                <b-form-datepicker id="date" v-model="form.date" locale="pt" class="mb-2"></b-form-datepicker>
                <div v-if="form.errors.date" class="invalid-feedback animated fadeIn">{{form.errors.date}}</div>
              </b-form-group>
              <b-form-group label="Início" label-for="start_time">
                <b-form-timepicker v-model="form.start_time" locale="pt"></b-form-timepicker>
                <div v-if="form.errors.start_time" class="invalid-feedback animated fadeIn">{{form.errors.start_time}}</div>
              </b-form-group>
              <b-form-group label="Fim" label-for="end_time">
                <b-form-timepicker v-model="form.end_time" locale="pt-pt"></b-form-timepicker>
                <div v-if="form.errors.end_time" class="invalid-feedback animated fadeIn">{{form.errors.end_time}}</div>
              </b-form-group>
              <b-form-group label="Tópico" label-for="topic">
                <b-form-input id="topic" type="text" v-model="form.topic" :class="{'is-invalid': form.errors.topic}"></b-form-input>
                <div v-if="form.errors.topic" class="invalid-feedback animated fadeIn">{{form.errors.topic}}</div>
              </b-form-group>
              <b-form-group label="Descrição" label-for="description">
                <b-form-textarea
                  id="description"
                  v-model="form.description"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.description" class="invalid-feedback animated fadeIn">{{form.errors.description}}</div>
            </b-form-group>
              <b-form-group label="Local" label-for="venue">
                <b-form-input id="venue" type="text" v-model="form.venue" :class="{'is-invalid': form.errors.venue}"></b-form-input>
                <div v-if="form.errors.venue" class="invalid-feedback animated fadeIn">{{form.errors.venue}}</div>
              </b-form-group>
              
                <b-button type="submit" class="btn btn-rounded" variant="brand" v-if="!form.processing">Registar</b-button>
                <b-button class="btn btn-block btn-rounded" variant="brand" v-if="form.processing">
                    <b-spinner small type="grow"></b-spinner>
                </b-button>
            </b-form>
          </div>
        </div>

      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
</template>