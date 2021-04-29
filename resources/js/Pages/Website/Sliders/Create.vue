<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateSlider",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Slider'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            title: null,
            description: null,
            width: null,
            height: null,
            images: [],
            page_id: null,
          }),
        }
        },
        methods: {
            addImage() {
              this.form.images.push({
                title: '',
                description: '',
                link: '#',
                image: null,
                imagepreview: null
              });
            },
            removeImage(index) {
              this.form.images.splice(index, 1);
            },
            imageSelected(index, e) {
              let reader = new FileReader();
              reader.readAsDataURL(this.form.images[index].image);
              reader.onload = e => {
                this.form.images[index].imagepreview = e.target.result;
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
          <h4 class="mb-0 font-size-18">Sliders</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.sliders.index')" method="get">
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
            <b-form @submit.prevent="form.post('/canvas/sliders')">
              <slot />
              <b-form-group label="Página" label-for="page_id">
              <multiselect
                  id="ajax"
                  v-model="form.page_id"
                  :options="$page.props.pages"
                  label="title"
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
              </b-form-group>
              <b-form-group label="Título" label-for="title">
                <b-form-input id="title" type="text" v-model="form.title" :class="{'is-invalid': form.errors.title}"></b-form-input>
                <div v-if="form.errors.title" class="invalid-feedback animated fadeIn">{{form.errors.title}}</div>
              </b-form-group>
              <b-form-group label="Descrição" label-for="description">
                <b-form-textarea
                  id="textarea"
                  v-model="form.description"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.description" class="invalid-feedback animated fadeIn">{{form.errors.description}}</div>
              </b-form-group>
              <b-form-group label="Largura" label-for="width">
                <b-form-input id="width" type="text" v-model="form.width" :class="{'is-invalid': form.errors.width}"></b-form-input>
                <div v-if="form.errors.width" class="invalid-feedback animated fadeIn">{{form.errors.width}}</div>
              </b-form-group>
              <b-form-group label="Altura" label-for="height">
                <b-form-input id="height" type="text" v-model="form.height" :class="{'is-invalid': form.errors.height}"></b-form-input>
                <div v-if="form.errors.height" class="invalid-feedback animated fadeIn">{{form.errors.height}}</div>
              </b-form-group>
                <b-button type="submit" class="btn btn-rounded" variant="brand" v-if="!form.processing">Registar</b-button>
                <b-button class="btn btn-block btn-rounded" variant="brand" v-if="form.processing">
                    <b-spinner small type="grow"></b-spinner>
                </b-button>
            </b-form>
          </div>
        </div>

      </div>

      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">
            <b-button size="sm" class="btn btn-rounded btn-block" @click="addImage" variant="primary">ADICIONAR IMAGEM</b-button>
            </h4>
          </div>
          <div class="m-2" v-for="(image, index) in form.images" :key="index">
            <b-form-group label="Título" :label-for="'title_' + index">
                <b-form-input :id="'title_' + index" type="text" v-model="image.title" :class="{'is-invalid': form.errors.title}"></b-form-input>
                <div v-if="form.errors.title" class="invalid-feedback animated fadeIn">{{form.errors.title}}</div>
            </b-form-group>
            <b-form-group label="Descrição" :label-for="'description_' + index">
                <b-form-textarea
                  :id="'description_' + index"
                  v-model="image.description"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.description" class="invalid-feedback animated fadeIn">{{form.errors.description}}</div>
            </b-form-group>
            <b-form-group label="Link" :label-for="'link_' + index">
                <b-form-input :id="'link_' + index" type="text" v-model="image.link" :class="{'is-invalid': form.errors.link}"></b-form-input>
                <div v-if="form.errors.link" class="invalid-feedback animated fadeIn">{{form.errors.link}}</div>
              </b-form-group>
            <b-form-group label="Imagem" :label-for="'image_' + index">
                <b-form-file :id="'image_' + index"
                          size="sm"
                          :name="'image_' + index"
                          browse-text="Procurar"
                          v-model="image.image"
                          placeholder="Escolha uma imagem ou arraste-o aqui"
                          drop-placeholder="Solte a imagem aqui"
                          @input="imageSelected(index)">
                </b-form-file>
            </b-form-group>
            <b-form-group label="Pre-visualização" :label-for="'imagepreview_' + index">
              <div class="col-md-5">
                  <img class="rounded" :src="image.imagepreview" alt="" width="200">
              </div>
            </b-form-group>
            <b-button size="sm" class="btn btn-rounded btn-block" @click="removeImage(index)" variant="danger">REMOVER IMAGEM</b-button>
            <hr>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
</template>