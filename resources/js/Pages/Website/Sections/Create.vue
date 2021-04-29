<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    import InlineEditor from "@rav23/ckeditor5-omdesignz";
    import '@rav23/ckeditor5-omdesignz/build/translations/pt-br.js';
    
    export default {
        name: "CreateSection",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Secções'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            title: null,
            description: null,
            page_id: null,
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
          <h4 class="mb-0 font-size-18">Secções</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.sections.index')" method="get">
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
            <b-form @submit.prevent="form.post('/canvas/sections')">
              <slot />
              <b-form-group label="Page" label-for="page_id">
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
                <ckeditor v-model="form.description" :editor="editor" :config="editorConf"></ckeditor>
                <div v-if="form.errors.description" class="invalid-feedback animated fadeIn">{{form.errors.description}}</div>
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