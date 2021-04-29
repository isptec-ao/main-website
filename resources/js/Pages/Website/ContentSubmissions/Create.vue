<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateContentSubmission",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Submissão de Conteúdo'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            title: null,
            category: 'N',
            name: null,
            email: null,
            contact: null,
            description_pt: null,
            description_en: null,
            obs: null,
            featured_image: null,
            imagepreview: null,
            documents: null,
          }),
          options: [
                        { text: 'Notícia', value: 'N' },
                        { text: 'Evento', value: 'E' },
                        { text: 'Outro', value: 'O' },
                    ],
        }
        },
        methods: {
            imageSelected(e) {
              let reader = new FileReader();
              reader.readAsDataURL(this.form.featured_image ? this.form.featured_image : new Blob());
              reader.onload = e => {
                this.form.imagepreview = e.target.result ? e.target.result : null;
              }
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
          <h4 class="mb-0 font-size-18">Submissão de Conteúdo</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.contentsubmissions.index')" method="get">
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
            <b-form @submit.prevent="form.post('/canvas/contentsubmissions')">
              <slot />
              <b-form-group label="Categoria" label-for="category">
                <b-form-radio-group
                    class="mt-2"
                    id="category"
                    v-model="form.category"
                    :options="options"
                    name="category"
                ></b-form-radio-group>
                <div v-if="form.errors.category" class="invalid-feedback animated fadeIn">{{form.errors.category}}</div>
            </b-form-group>
              <b-form-group label="Título" label-for="title">
                <b-form-input id="title" type="text" v-model="form.title" :class="{'is-invalid': form.errors.title}"></b-form-input>
                <div v-if="form.errors.title" class="invalid-feedback animated fadeIn">{{form.errors.title}}</div>
              </b-form-group>
              <b-form-group label="Autor" label-for="name">
                <b-form-input id="name" type="text" v-model="form.name" :class="{'is-invalid': form.errors.name}"></b-form-input>
                <div v-if="form.errors.name" class="invalid-feedback animated fadeIn">{{form.errors.name}}</div>
              </b-form-group>
              <b-form-group label="Email" label-for="email">
                <b-form-input id="email" type="text" v-model="form.email" :class="{'is-invalid': form.errors.email}"></b-form-input>
                <div v-if="form.errors.email" class="invalid-feedback animated fadeIn">{{form.errors.email}}</div>
              </b-form-group>
              <b-form-group label="Contacto" label-for="contact">
                <b-form-input id="contact" type="text" v-model="form.contact" :class="{'is-invalid': form.errors.contact}"></b-form-input>
                <div v-if="form.errors.contact" class="invalid-feedback animated fadeIn">{{form.errors.contact}}</div>
              </b-form-group>
              <b-form-group label="Descrição PT" label-for="description_pt">
                <b-form-textarea
                  id="description_pt"
                  v-model="form.description_pt"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.description_pt" class="invalid-feedback animated fadeIn">{{form.errors.description_pt}}</div>
            </b-form-group>

            <b-form-group label="Descrição EN" label-for="description_en">
                <b-form-textarea
                  id="description_en"
                  v-model="form.description_en"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.description_en" class="invalid-feedback animated fadeIn">{{form.errors.description_en}}</div>
            </b-form-group>

            <b-form-group label="OBS" label-for="obs">
                <b-form-textarea
                  id="obs"
                  v-model="form.obs"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.obs" class="invalid-feedback animated fadeIn">{{form.errors.obs}}</div>
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
            <h4 class="card-title mb-4">Imagem e Documentos</h4>
            <b-form-group label="Image" label-for="image">
            <b-input-group>
                <b-form-file id="image"
                          size="sm"
                          name="image"
                          browse-text="Procurar"
                          v-model="form.featured_image"
                          placeholder="Escolha uma imagem ou arraste-o aqui"
                          drop-placeholder="Solte a imagem aqui"
                          @input="imageSelected">
                </b-form-file>
                <template #append>
                  <b-button size="sm" @click="form.imagepreview = null, form.featured_image = null">
                      <i class="bx bx-trash"></i>
                  </b-button>
                </template>
              </b-input-group>
            </b-form-group>
            <b-form-group label="Pre-visualização" label-for="imagepreview">
              <div class="col-md-5">
                  <img class="rounded" :src="form.imagepreview" alt="" width="200">
              </div>
            </b-form-group>
            <hr>
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