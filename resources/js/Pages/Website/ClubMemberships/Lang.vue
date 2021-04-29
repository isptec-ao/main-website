<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    import InlineEditor from "@rav23/ckeditor5-omdesignz";
    import '@rav23/ckeditor5-omdesignz/build/translations/pt-br.js';
    
    export default {
        name: "LangClubMembership",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              clubmembership: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Clube - Inscrições'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            name: this.$page.props.clubmembership.name,
            surname: this.$page.props.clubmembership.surname,
            email: this.$page.props.clubmembership.email,
            category_id: this.$page.props.clubmembership.category,
            member_type: this.$page.props.clubmembership.member_type,
            lang: this.$page.props.lang
          }),
          options: [
                        { text: 'Estudante', value: 'S' },
                        { text: 'Funcionario', value: 'E' },
                        { text: 'Outro', value: 'O' },
                    ],
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
              this.$inertia.put(this.route('canvas.clubmemberships.settranslation', id));
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
          <h4 class="mb-0 font-size-18">Clube - Inscrições</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.clubmemberships.index')" method="get">
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

            <!-- Create Clube - Inscrições Form -->
            <b-form @submit.prevent="form.put(route('canvas.clubmemberships.settranslation', $page.props.clubmembership.id))">
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
              <b-form-group label="Nome" label-for="name">
                <b-form-input id="name" type="text" v-model="form.name" :class="{'is-invalid': form.errors.name}"></b-form-input>
                <div v-if="form.errors.name" class="invalid-feedback animated fadeIn">{{form.errors.name}}</div>
              </b-form-group>
              <b-form-group label="Apelido" label-for="surname">
                <b-form-input id="surname" type="text" v-model="form.surname" :class="{'is-invalid': form.errors.surname}"></b-form-input>
                <div v-if="form.errors.surname" class="invalid-feedback animated fadeIn">{{form.errors.surname}}</div>
              </b-form-group>
              <b-form-group label="Email" label-for="email">
                <b-form-input id="email" type="email" v-model="form.email" :class="{'is-invalid': form.errors.email}"></b-form-input>
                <div v-if="form.errors.email" class="invalid-feedback animated fadeIn">{{form.errors.email}}</div>
              </b-form-group>
              <b-form-group label="Categoria" label-for="member_type">
                <b-form-radio-group
                    class="mt-2"
                    id="member_type"
                    v-model="form.member_type"
                    :options="options"
                    name="member_type"
                ></b-form-radio-group>
                <div v-if="form.errors.member_type" class="invalid-feedback animated fadeIn">{{form.errors.member_type}}</div>
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