<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create New Service
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div
            v-if="service || image_url"
            class="w-24 h-24 float-right mr-3 mt-2 object-cover bg-cover bg-center bg-no-repeat rounded"
            :style="
              image_url
                ? 'background-image: url(' + image_url + ')'
                : 'background-image: url(' + service.image_url + ')'
            "
          ></div>
          <form
            ref="saveService"
            @submit.prevent="saveService"
            class="w-full py-3 flex flex-wrap justify-between items-center"
          >
            <!-- Name -->
            <div class="w-full md:w-1/2 px-3">
              <jet-label value="Service Title" />
              <jet-input
                ref="title"
                type="text"
                class="mt-1 block w-full"
                v-model="form.title"
                autocomplete="title"
              />
              <jet-input-error :message="form.error('title')" class="mt-2" />
            </div>

            <!-- image -->
            <div class="w-full md:w-1/2 px-3">
              <jet-label value="Image" />
              <input
                type="file"
                @change="setImg"
                accept="image/*"
                class="w-full mt-1 block form-input rounded-md shadow-sm"
                ref="image"
              />
              <jet-input-error :message="form.error('image')" class="mt-2" />
            </div>
            <!-- Discription -->
            <div class="w-full px-3">
              <jet-label value="Discraption" />
              <textarea
                class="w-full mt-1 block rounded border border-gray-400 focus:outline-none px-2 py-2"
                v-model="form.discraption"
                id=""
                rows="10"
                placeholder="Discraption"
              ></textarea>
              <jet-input-error
                :message="form.error('discraption')"
                class="mt-2"
              />
            </div>
            <div
              class="w-full flex order-0 items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6"
            >
              <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
              </jet-action-message>

              <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Save
              </jet-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
export default {
  data() {
    return {
      image_url: null,
      form: this.$inertia.form(
        {
          title: this.service ? this.service.title : "",
          discraption: this.service ? this.service.discraption : "",
          image: null,
        },
        {
          bag: "Createservice",
          resetOnSuccess: true,
        }
      ),
    };
  },
  methods: {
    saveService() {
      if (this.service) {
        let form = this.$inertia.form(
          {
            _method: 'PUT',
            title: this.form.title, //
            discraption: this.form.discraption,
            image: this.form.image
          },
          {
            bag: "Createservice",
            resetOnSuccess: true,
          }
        );
  console.log(form);
        form.post(route("service.update", this.service.id), {
          preserveScroll: true,
        });
      } else {
        this.form
          .post(route("service.store"), {
            preserveScroll: true,
          })
          .then(() => {
            if (this.form.recentlySuccessful) {
              this.form.reset();
              this.$refs.saveService.reset();
              this.$refs.title.focus();
              this.image_url = null;
            }
          });
      }
    },
    setImg() {
      this.form.image = this.$refs.image.files[0];
      const reader = new FileReader();

      reader.onload = (e) => {
        this.image_url = e.target.result;
      };

      reader.readAsDataURL(this.$refs.image.files[0]);
    },
  },
  props: {
    service: {
      type: Object,
      default: null,
    },
  },
  components: {
    AppLayout,
    JetActionMessage,
    JetButton,
    JetInput,
    JetInputError,
    JetLabel,
  },
};
</script>