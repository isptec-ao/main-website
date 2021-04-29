<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateRecruitmentSubmission",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Recrutamento - Candidaturas'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            pub_id: null,  
            acad_id: null,  
            full_name: null,
            gender: 'M',
            id_no: null,
            naturality: null,
            dob: null,
            email: null,
            tel_no: null,
            country: null,
            marital_status: 'S',
            address: null,
            suburb: null,
            postal_code: null,
            work_experience: null,
            other_info: null,
            documents: null,
          }),
          genderOptions: [
                        { text: 'Masculino', value: 'M' },
                        { text: 'Feminino', value: 'F' },
                    ],
                    maritalOptions: [
                        { text: 'Solteiro(a)', value: 'S' },
                        { text: 'Casado(a)', value: 'M' },
                        { text: 'Divorciado(a)', value: 'D' },
                        { text: 'Viuvo(a)', value: 'W' },
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
          <h4 class="mb-0 font-size-18">Recrutamento - Candidaturas</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.recruitmentsubmissions.index')" method="get">
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
            <b-form @submit.prevent="form.post('/canvas/recruitmentsubmissions')">
              <slot />
              <b-form-group label="Publicação" label-for="pub_id">
              <multiselect
                  id="ajax"
                  v-model="form.pub_id"
                  :options="$page.props.recruitmentpublications"
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
              <div v-if="form.errors.pub_id" class="invalid-feedback animated fadeIn">{{form.errors.pub_id}}</div>
              </b-form-group>
              <b-form-group label="Nome Completo" label-for="full_name">
                <b-form-input id="full_name" type="text" v-model="form.full_name" :class="{'is-invalid': form.errors.full_name}"></b-form-input>
                <div v-if="form.errors.full_name" class="invalid-feedback animated fadeIn">{{form.errors.full_name}}</div>
              </b-form-group>
              <b-form-group label="Grau Académico" label-for="acad_id">
              <multiselect
                  id="ajax"
                  v-model="form.acad_id"
                  :options="$page.props.academiccategories"
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
              <div v-if="form.errors.acad_id" class="invalid-feedback animated fadeIn">{{form.errors.acad_id}}</div>
              </b-form-group>
              <b-form-group label="N. B.I." label-for="id_no">
                <b-form-input id="id_no" type="text" v-model="form.id_no" :class="{'is-invalid': form.errors.id_no}"></b-form-input>
                <div v-if="form.errors.id_no" class="invalid-feedback animated fadeIn">{{form.errors.id_no}}</div>
              </b-form-group>
              <b-form-group label="Naturalidade" label-for="naturality">
                <b-form-input id="naturality" type="text" v-model="form.naturality" :class="{'is-invalid': form.errors.naturality}"></b-form-input>
                <div v-if="form.errors.naturality" class="invalid-feedback animated fadeIn">{{form.errors.naturality}}</div>
              </b-form-group>
              <b-form-group label="Gênero" label-for="gender">
                <b-form-radio-group
                    class="mt-2"
                    id="gender"
                    v-model="form.gender"
                    :options="genderOptions"
                    name="gender"
                ></b-form-radio-group>
                <div v-if="form.errors.gender" class="invalid-feedback animated fadeIn">{{form.errors.gender}}</div>
            </b-form-group>
            <b-form-group label="Estado Civil" label-for="marital_status">
                <b-form-radio-group
                    class="mt-2"
                    id="marital_status"
                    v-model="form.marital_status"
                    :options="maritalOptions"
                    name="marital_status"
                ></b-form-radio-group>
                <div v-if="form.errors.marital_status" class="invalid-feedback animated fadeIn">{{form.errors.marital_status}}</div>
            </b-form-group>
            <b-form-group label="Endereço" label-for="address">
                <b-form-input id="address" type="text" v-model="form.address" :class="{'is-invalid': form.errors.address}"></b-form-input>
                <div v-if="form.errors.address" class="invalid-feedback animated fadeIn">{{form.errors.address}}</div>
              </b-form-group>
              <b-form-group label="País" label-for="country">
                <b-form-input id="country" type="text" v-model="form.country" :class="{'is-invalid': form.errors.country}"></b-form-input>
                <div v-if="form.errors.country" class="invalid-feedback animated fadeIn">{{form.errors.country}}</div>
              </b-form-group>
              <b-form-group label="Município" label-for="suburb">
                <b-form-input id="suburb" type="text" v-model="form.suburb" :class="{'is-invalid': form.errors.suburb}"></b-form-input>
                <div v-if="form.errors.suburb" class="invalid-feedback animated fadeIn">{{form.errors.suburb}}</div>
              </b-form-group>
              <b-form-group label="Código Postal" label-for="postal_code">
                <b-form-input id="postal_code" type="text" v-model="form.postal_code" :class="{'is-invalid': form.errors.postal_code}"></b-form-input>
                <div v-if="form.errors.postal_code" class="invalid-feedback animated fadeIn">{{form.errors.postal_code}}</div>
              </b-form-group>
              <b-form-group label="Email" label-for="email">
                <b-form-input id="email" type="text" v-model="form.email" :class="{'is-invalid': form.errors.email}"></b-form-input>
                <div v-if="form.errors.email" class="invalid-feedback animated fadeIn">{{form.errors.email}}</div>
              </b-form-group>
              <b-form-group label="Tel No" label-for="tel_no">
                <b-form-input id="tel_no" type="text" v-model="form.tel_no" :class="{'is-invalid': form.errors.tel_no}"></b-form-input>
                <div v-if="form.errors.tel_no" class="invalid-feedback animated fadeIn">{{form.errors.tel_no}}</div>
              </b-form-group>
              <b-form-group label="Data de Nascimento" label-for="dob">
                <b-form-datepicker id="dob" v-model="form.dob" locale="pt" class="mb-2"></b-form-datepicker>
                <div v-if="form.errors.dob" class="invalid-feedback animated fadeIn">{{form.errors.dob}}</div>
              </b-form-group>
              <b-form-group label="Experiência" label-for="work_experience">
                <b-form-textarea
                  id="work_experience"
                  v-model="form.work_experience"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.work_experience" class="invalid-feedback animated fadeIn">{{form.errors.work_experience}}</div>
            </b-form-group>
            <b-form-group label="Informações Adicionais" label-for="other_info">
                <b-form-textarea
                  id="other_info"
                  v-model="form.other_info"
                  placeholder=""
                  rows="3"
                  max-rows="6"
                ></b-form-textarea>
                <div v-if="form.errors.other_info" class="invalid-feedback animated fadeIn">{{form.errors.other_info}}</div>
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