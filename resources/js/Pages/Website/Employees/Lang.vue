<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "LangEmployee",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
              employee: Object,
              lang: String,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Funcionários'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            title: this.$page.props.employee.title,
            full_name: this.$page.props.employee.full_name,
            email: this.$page.props.employee.email,
            dob: this.$page.props.employee.dob,
            tel_no: this.$page.props.employee.tel_no,
            extension: this.$page.props.employee.extension,
            orchid_id: this.$page.props.employee.orchid_id,
            gender: this.$page.props.employee.gender,
            receive_bday_notification: this.$page.props.employee.receive_bday_notification,
            is_lecturer: this.$page.props.employee.is_lecturer,
            is_national: this.$page.props.employee.is_national,
            description: this.$page.props.employee.description,
            avatar: null,
            imagepreview: null,
            documents: null,
            lang: this.$page.props.lang,
            _method: 'PUT'
          }),
          options: [
                        { text: 'Masculino', value: 'M' },
                        { text: 'Feminino', value: 'F' },
                    ],
        }
        },
        methods: {
            settranslation(id) {
              this.$inertia.put(this.route('canvas.employees.settranslation', id));
          },
          imageSelected(e) {
              let reader = new FileReader();
              reader.readAsDataURL(this.form.avatar ? this.form.avatar : new Blob());
              reader.onload = e => {
                this.form.imagepreview = e.target.result ? e.target.result : null;
              }
            },
          downloadAllAttachments () {
                window.open(route('canvas.employees.downloadallattachments') + '?model_id=' + this.$page.post.id);
            },

            downloadSingleAttachment (id) {
                window.open(route('canvas.employees.downloadsingleattachment') + '?model_id=' + id);
            },
            deleteSingleAttachment (id) {
                window.open(route('canvas.employees.deletesingleattachment') + '?model_id=' + id);
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
          <h4 class="mb-0 font-size-18">Funcionários</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.employees.index')" method="get">
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
            <h4 class="card-title mb-4">Adicionar Translation: {{ $page.props.lang.toUpperCase() }}</h4>

            <!-- Create Service Categories Form -->
            <b-form @submit.prevent="form.post(route('canvas.employees.settranslation', $page.props.employee.id))">
              <slot />
              <b-form-group label="Nome Completo" label-for="full_name">
                <b-form-input id="full_name" type="text" v-model="form.full_name" :class="{'is-invalid': form.errors.full_name}"></b-form-input>
                <div v-if="form.errors.full_name" class="invalid-feedback animated fadeIn">{{form.errors.full_name}}</div>
              </b-form-group>
              <b-form-group label="Email" label-for="email">
                <b-form-input id="email" type="text" v-model="form.email" :class="{'is-invalid': form.errors.email}"></b-form-input>
                <div v-if="form.errors.email" class="invalid-feedback animated fadeIn">{{form.errors.email}}</div>
              </b-form-group>
            <b-form-group label="Gênero" label-for="gender">
                <b-form-radio-group
                    class="mt-2"
                    id="gender"
                    v-model="form.gender"
                    :options="options"
                    name="gender"
                ></b-form-radio-group>
                <div v-if="form.errors.gender" class="invalid-feedback animated fadeIn">{{form.errors.gender}}</div>
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
            <b-form-group label="Docente?" label-for="is_lecturer">
                  <b-form-checkbox switch class="mt-2 custom-control custom-switch" v-model="form.is_lecturer" id="is_lecturer">
                      {{ (form.is_lecturer ? 'SIM' : 'NÃO') }}
                  </b-form-checkbox>
              </b-form-group>
              <b-form-group label="Nacional?" label-for="is_national">
                  <b-form-checkbox switch class="mt-2 custom-control custom-switch" v-model="form.is_national" id="is_national">
                      {{ (form.is_national ? 'SIM' : 'NÃO') }}
                  </b-form-checkbox>
              </b-form-group>
            <b-form-group label="Tel No" label-for="tel_no">
                <b-form-input id="tel_no" type="text" v-model="form.tel_no" :class="{'is-invalid': form.errors.tel_no}"></b-form-input>
                <div v-if="form.errors.tel_no" class="invalid-feedback animated fadeIn">{{form.errors.tel_no}}</div>
              </b-form-group>
              <b-form-group label="Extensão" label-for="extension">
                <b-form-input id="extension" type="text" v-model="form.extension" :class="{'is-invalid': form.errors.extension}"></b-form-input>
                <div v-if="form.errors.extension" class="invalid-feedback animated fadeIn">{{form.errors.extension}}</div>
              </b-form-group>
              <b-form-group label="Orchid ID" label-for="orchid_id">
                <b-form-input id="orchid_id" type="text" v-model="form.orchid_id" :class="{'is-invalid': form.errors.orchid_id}"></b-form-input>
                <div v-if="form.errors.orchid_id" class="invalid-feedback animated fadeIn">{{form.errors.orchid_id}}</div>
              </b-form-group>
            <b-form-group label="Data de Nascimento" label-for="dob">
                <b-form-datepicker id="dob" v-model="form.dob" locale="pt" class="mb-2"></b-form-datepicker>
                <div v-if="form.errors.dob" class="invalid-feedback animated fadeIn">{{form.errors.dob}}</div>
              </b-form-group>

              <b-form-group label="Receber Notificação?" label-for="receive_bday_notification">
                  <b-form-checkbox switch class="mt-2 custom-control custom-switch" v-model="form.receive_bday_notification" id="receive_bday_notification">
                      {{ (form.receive_bday_notification ? 'SIM' : 'NÃO') }}
                  </b-form-checkbox>
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
                          v-model="form.avatar"
                          placeholder="Escolha uma imagem ou arraste-o aqui"
                          drop-placeholder="Solte a imagem aqui"
                          @input="imageSelected">
                </b-form-file>
                <template #append>
                  <b-button size="sm" @click="form.imagepreview = null, form.avatar = null">
                      <i class="bx bx-trash"></i>
                  </b-button>
                </template>
              </b-input-group>
            </b-form-group>
            <b-form-group label="Pre-visualização" label-for="imagepreview">
              <div class="col-md-5">
                  <img class="rounded" :src="$page.props.employee.avatar_link && !form.avatar ? $page.props.employee.avatar_link : form.imagepreview" alt="" width="200">
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
          <b-form-group>
          <table class="table table-centered table-hover" v-if="$page.props.documents">
                <tbody>
                  <tr v-for="(document, index) in $page.props.documents" :key="index">
                    <td>
                      <h5 class="font-size-14 mb-1">
                        <small><a href="javascript: void(0);" class="text-dark">{{ document.name }}</a></small>
                      </h5>
                      <small>{{ document.size }}</small>
                    </td>
                    <td>
                      <div class="text-center">
                        <a href="javascript: void(0);" class="text-dark">
                          <i class="bx bx-trash h6 text-danger m-0" @click="deleteSingleAttachment(document.id)"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              </b-form-group>
        </div>  
    </div>
    </div>
    <!-- end row -->
  </div>
</template>