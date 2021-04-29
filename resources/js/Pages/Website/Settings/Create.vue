<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateSetting",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Definições'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            option: null,
            value: null,
            documents: null,
          })
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
          <h4 class="mb-0 font-size-18">Definições</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.settings.index')" method="get">
                    <i class="bx bx-arrow-back"></i>
                </inertia-link>
            </b-button-group>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-lg-7">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Adicionar</h4>

            <!-- Create Departments Form -->
            <b-form @submit.prevent="form.post('/canvas/settings')">
              <slot />
            
              <b-form-group label="Descrição" label-for="option">
                <b-form-input id="option" type="text" v-model="form.option" :class="{'is-invalid': form.errors.option}"></b-form-input>
                <div v-if="form.errors.option" class="invalid-feedback animated fadeIn">{{form.errors.option}}</div>
              </b-form-group>
              <b-form-group label="Valor" label-for="value">
                <b-form-textarea
                  id="value"
                  v-model="form.value"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.value" class="invalid-feedback animated fadeIn">{{form.errors.value}}</div>
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
      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Documentos</h4>
            <b-form-group label="Documentos" label-for="documents">
              <b-input-group>
                <b-form-file id="documents"
                          multiple
                          size="sm"
                          name="documents"
                          browse-text="Procurar"
                          v-model="form.documents"
                          placeholder="Escolha um ficheiro ou arraste-o aqui"
                          drop-placeholder="Solte o ficheiro aqui">
                </b-form-file>
                <template #append>
                  <b-button size="sm" @click="form.documents = null">
                      <i class="bx bx-trash"></i>
                  </b-button>
                </template>
              </b-input-group>
            </b-form-group>
          </div>
        </div>  
    </div>
    <!-- end row -->
  </div>
  </div>
</template>