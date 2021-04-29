<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    import InlineEditor from "@rav23/ckeditor5-omdesignz";
    import '@rav23/ckeditor5-omdesignz/build/translations/pt-br.js';
    
    export default {
        name: "LangPartnerCategory",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              partnercategory: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Protocolos e Parcerias - Categorias'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            name: this.$page.props.partnercategory.name,
            description: this.$page.props.partnercategory.description,
            lang: this.$page.props.lang
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
            settranslation(id) {
              this.$inertia.put(this.route('canvas.partnercategories.settranslation', id));
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
          <h4 class="mb-0 font-size-18">Protocolos e Parcerias - Categorias</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.partnercategories.index')" method="get">
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
            <h4 class="card-title mb-4">Adicionar Translation: {{ $page.props.lang.toUpperCase() }}</h4>

            <!-- Create Protocolos e Parcerias - Categorias Form -->
            <b-form @submit.prevent="form.put(route('canvas.partnercategories.settranslation', $page.props.partnercategory.id))">
              <slot />
              <b-form-group label="Nome" label-for="name">
                <b-form-input id="name" type="text" v-model="form.name" :class="{'is-invalid': form.errors.name}"></b-form-input>
                <div v-if="form.errors.name" class="invalid-feedback animated fadeIn">{{form.errors.name}}</div>
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