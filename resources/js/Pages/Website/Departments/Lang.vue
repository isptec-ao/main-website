<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    import InlineEditor from "@rav23/ckeditor5-omdesignz";
    import '@rav23/ckeditor5-omdesignz/build/translations/pt-br.js';
    
    export default {
        name: "LangDepartment",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              department: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Departamentos'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            name: this.$page.props.department.name,
            code: this.$page.props.department.code,
            email: this.$page.props.department.email,
            tel_no: this.$page.props.department.tel_no,
            description: this.$page.props.department.description,
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
              this.$inertia.put(this.route('canvas.departments.settranslation', id));
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
          <h4 class="mb-0 font-size-18">Departamentos</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.departments.index')" method="get">
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

            <!-- Create Departments Form -->
            <b-form @submit.prevent="form.put(route('canvas.departments.settranslation', $page.props.department.id))">
              <slot />
              <b-form-group label="Nome" label-for="name">
                <b-form-input id="name" type="text" v-model="form.name" :class="{'is-invalid': form.errors.name}"></b-form-input>
                <div v-if="form.errors.name" class="invalid-feedback animated fadeIn">{{form.errors.name}}</div>
              </b-form-group>
              <b-form-group label="Sígla" label-for="code">
                <b-form-input id="code" type="text" v-model="form.code" :class="{'is-invalid': form.errors.code}"></b-form-input>
                <div v-if="form.errors.code" class="invalid-feedback animated fadeIn">{{form.errors.code}}</div>
              </b-form-group>
              <b-form-group label="Descrição" label-for="description">
                <ckeditor v-model="form.description" :editor="editor" :config="editorConf"></ckeditor>
                <div v-if="form.errors.description" class="invalid-feedback animated fadeIn">{{form.errors.description}}</div>
              </b-form-group>
              <b-form-group label="Email" label-for="email">
                <b-form-input id="email" type="text" v-model="form.email" :class="{'is-invalid': form.errors.email}"></b-form-input>
                <div v-if="form.errors.email" class="invalid-feedback animated fadeIn">{{form.errors.email}}</div>
              </b-form-group>
              <b-form-group label="Extensão" label-for="tel_no">
                <b-form-input id="tel_no" type="text" v-model="form.tel_no" :class="{'is-invalid': form.errors.tel_no}"></b-form-input>
                <div v-if="form.errors.tel_no" class="invalid-feedback animated fadeIn">{{form.errors.tel_no}}</div>
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