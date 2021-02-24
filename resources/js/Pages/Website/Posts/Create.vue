<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    import InlineEditor from "@rav23/ckeditor5-omdesignz";
    import '@rav23/ckeditor5-omdesignz/build/translations/pt-br.js';
    
    export default {
        name: "CreatePost",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              tags: Object,
              topics: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Posts'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            title: null,
            body: null,
            summary: null,
            published_at: null,
            featured_image: null,
            featured_image_caption: null,
            featured_images: null,
            documents: null,
            topics: [],
            tags: [],
          }),
          editor: InlineEditor,
                editorConf: {
                    language: 'pt-br',
                    toolbar: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        // 'imageUpload',
                        'blockQuote',
                        'insertTable',
                        'mediaEmbed',
                        'fontFamily',
                        'fontSize',
                        'fontColor',
                        'fontBackgroundColor',
                        'specialcharacters',
                        'htmlembed',
                        'highlight',
                        'horizontalline',
                        'pagebreak',
                        'codeBlock',
                        'subscript',
                        'superscript',
                        'strikethrough',
                        'tablecellproperties',
                        'tableproperties',
                        'undo',
                        'redo'
                    ]
                }
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
          <h4 class="mb-0 font-size-18">Posts</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.posts.index')" method="get">
                    <i class="bx bx-arrow-back"></i>
                </inertia-link>
            </b-button-group>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Conteudo</h4>

            <!-- Create Posts Form -->
            <b-form @submit.prevent="form.post('/canvas/posts')">
              <slot />
              <b-form-group label="Body" label-for="body">
                <ckeditor v-model="form.body" :editor="editor" :config="editorConf"></ckeditor>
                <div v-if="form.errors.body" class="invalid-feedback animated fadeIn">{{form.errors.body}}</div>
              </b-form-group>
              <b-form-group label="Title" label-for="title">
                <b-form-input id="title" type="text" v-model="form.title" :class="{'is-invalid': form.errors.title}"></b-form-input>
                <div v-if="form.errors.title" class="invalid-feedback animated fadeIn">{{form.errors.title}}</div>
              </b-form-group>
              <b-form-group label="Summary" label-for="summary">
                <b-form-input id="summary" type="text" v-model="form.summary" :class="{'is-invalid': form.errors.summary}"></b-form-input>
                <div v-if="form.errors.summary" class="invalid-feedback animated fadeIn">{{form.errors.summary}}</div>
              </b-form-group>

              <b-form-group label="Imagem de Capa" label-for="featured_image">
                  <b-form-file id="featured_image"
                            name="featured_image"
                            browse-text="Procurar"
                            v-model="form.featured_image"
                            placeholder="Escolha uma imagem ou arraste-o aqui"
                            drop-placeholder="Solte a imagem aqui">
                  </b-form-file>
              </b-form-group>

              <b-form-group label="Caption" label-for="featured_image_caption">
                <b-form-input id="featured_image_caption" type="text" v-model="form.featured_image_caption" :class="{'is-invalid': form.errors.featured_image_caption}"></b-form-input>
                <div v-if="form.errors.featured_image_caption" class="invalid-feedback animated fadeIn">{{form.errors.featured_image_caption}}</div>
              </b-form-group>

              <b-form-group label="Publish At" label-for="published_at">
              <date-picker input-class="form-control"
                            v-model="form.published_at"
                            append-to-body
                            lang="pt"
                            type="datetime"
                            valueType="format"
                            format="YYYY-MM-DD hh:mm:ss"
                           
                            >
                  <template slot="icon-calendar">
                      <i class="bx bx-calendar"></i>
                  </template>
              </date-picker>
              </b-form-group>

              <b-form-group label="Tags" label-for="tags">
              <multiselect
                  id="ajax"
                  v-model="form.tags"
                  :options="$page.props.tags"
                  label="name"
                  track-by="id"
                  placeholder="Escreva para pesquisar"
                  open-direction="bottom"
                  deselect-label="Pressione Enter para excluir"
                  select-label="Pressione Enter para seleccionar"
                  selected-label="Seleccionado"
                  tag-placeholder="Pressione Enter para criar etiqueta"
                  :multiple="true"
              >
              <span slot="noOptions">A lista está vazia</span>
              </multiselect>
              </b-form-group>

              <b-form-group label="Topics" label-for="topics">
              <multiselect
                  id="ajax"
                  v-model="form.topics"
                  :options="$page.props.topics"
                  label="name"
                  track-by="id"
                  placeholder="Escreva para pesquisar"
                  open-direction="bottom"
                  deselect-label="Pressione Enter para excluir"
                  select-label="Pressione Enter para seleccionar"
                  selected-label="Seleccionado"
                  tag-placeholder="Pressione Enter para criar etiqueta"
                  :multiple="true"
              >
              <span slot="noOptions">A lista está vazia</span>
              </multiselect>
              </b-form-group>
              
                <b-button type="submit" class="btn btn-rounded" variant="brand" v-if="!form.processing">Registar</b-button>
                <b-button class="btn btn-block btn-rounded" variant="brand" v-if="form.processing">
                    <b-spinner small type="grow"></b-spinner>
                </b-button>
            </b-form>
          </div>
        </div>

      </div>

      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Imagens</h4>
            <b-form-group label="Imagens" label-for="featured_images">
                <b-form-file id="featured_images"
                          multiple
                          size="sm"
                          name="featured_images"
                          browse-text="Procurar"
                          v-model="form.featured_images"
                          placeholder="Escolha uma imagem ou arraste-o aqui"
                          drop-placeholder="Solte a imagem aqui">
                </b-form-file>
            </b-form-group>
            <b-form-group label="Documentos" label-for="documents">
                <b-form-file id="documents"
                          multiple
                          size="sm"
                          name="documents"
                          browse-text="Procurar"
                          v-model="form.documents"
                          placeholder="Escolha um ficheiro ou arraste-o aqui"
                          drop-placeholder="Solte o ficheiro aqui">
                </b-form-file>
            </b-form-group>
          </div>
        </div>

      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
</template>