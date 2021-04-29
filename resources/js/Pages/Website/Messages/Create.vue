<script>
    import BaseCanvasLayout from '@/Shared/CanvasLayout'
    
    export default {
        name: "CreateMessage",
        layout: (h, dashboard) => h(BaseCanvasLayout, {
            props: {
              errors: Object,
            }
        }, [dashboard]),

        metaInfo: {
            title: 'Felicitações'
        },
        components: {
            
        },
        data () {
          return {
            form: this.$inertia.form({
            description: '',
            gender: 'A',
            banner: null,
            imagepreview: null
          }),
          options: [
                        { text: 'Ambos', value: 'A' },
                        { text: 'Masculino', value: 'M' },
                        { text: 'Feminino', value: 'F' },
                    ],
        }
        },
        methods: {
            imageSelected(e) {
              let reader = new FileReader();
              reader.readAsDataURL(this.form.banner ? this.form.banner : new Blob());
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
          <h4 class="mb-0 font-size-18">Felicitações</h4>

          <div class="page-title-right">
            <b-button-group class="btn-group-sm mt-2">
                <b-button v-b-modal.action-info variant="secondary">
                    <i class="bx bx-info-circle"></i>
                </b-button>
                <inertia-link class="btn btn-secondary" :href="route('canvas.messages.index')" method="get">
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
            <b-form @submit.prevent="form.post('/canvas/messages')">
              <slot />
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
            <h4 class="card-title mb-4">Imagem</h4>
            <b-form-group label="Image" label-for="image">
            <b-input-group>
                <b-form-file id="banner"
                          name="banner"
                          browse-text="Procurar"
                          v-model="form.banner"
                          placeholder="Escolha um arquivo ou arraste-o aqui"
                          drop-placeholder="Solte o qrquivo aqui"
                          @input="imageSelected">
                </b-form-file>
                <template #append>
                  <b-button size="sm" @click="form.imagepreview = null, form.banner = null">
                      <i class="bx bx-trash"></i>
                  </b-button>
                </template>
              </b-input-group>
            </b-form-group>
            <b-form-group label="Image Preview" label-for="imagepreview">
              <div class="col-md-5">
                  <img class="rounded" :src="form.imagepreview" alt="" width="200">
              </div>
            </b-form-group>
            
          </div>
        </div>  
    </div>
    <!-- end row -->
  </div>
  </div>
</template>