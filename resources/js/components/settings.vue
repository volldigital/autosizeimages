<template>
  <div class="settings-wrapper shadow bg-white p-4 rounded-lg mb-6">
    <h3>Size Configs</h3>

    <p class="my-1">Please note: 0px in either width or height means that the property will not be used for resizing. A
      single
      value keeps the aspect ratio and resizes the image accordingly.</p>

    <div class="mt-3">
      <template v-for="(config, i) in size_configs">
        <div class="flex items-center justify-between">
          <div class="font-bold my-2">Preset {{ i + 1 }}</div>
          <div class="flex items-center">
            <div class="width mr-2">
              <span class="font-bold mr-1">Width:</span>
              <input class="form-input text-right" type="number" :value="config.width || 0"
                     @input="(e) => config.width = parseInt(e.target.value)" style="width: 100px">
              <span>px</span>
            </div>
            <div class="height mr-4">
              <span class="font-bold mr-1">Height:</span>
              <input class="form-input text-right" type="number" :value="config.height || 0"
                     @input="(e) => config.height = parseInt(e.target.value)" style="width: 100px">
              <span>px</span>
            </div>
            <div class="text-red hover:text-red-light cursor-pointer" @click="deletePreset(i)">
              <svg-icon name="trash" class="h-4 w-4"/>
            </div>
          </div>
        </div>

        <hr>
      </template>

      <div class="w-100 text-right mt-4">
        <button class="btn btn-success" @click="addPreset">Add preset</button>
        <button class="btn btn-primary" @click="save">Save</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: "Settings",
  props: {
    saveAction: {
      required: true,
      type: String
    },
    sizeConfigs: {
      required: true,
      type: String
    }
  },
  data() {
    return {
      size_configs: []
    }
  },
  mounted() {
    let {size_configs} = JSON.parse(this.sizeConfigs);
    size_configs = this.cleanSizeConfigs(size_configs);

    this.size_configs = size_configs;
  },
  methods: {
    cleanSizeConfigs(size_configs) {
      return size_configs ? size_configs.map(c => {
        const preset = {}

        if (c.hasOwnProperty("width") && c.width > 0) {
          preset["width"] = c.width
        }

        if (c.hasOwnProperty("height") && c.height > 0) {
          preset["height"] = c.height
        }

        return preset
      }) : [];
    },
    addPreset() {
      this.size_configs.push({width: 100})
    },
    deletePreset(index) {
      this.size_configs.splice(index, 1);
    },
    async save() {
      await axios.post(this.saveAction, {
        size_configs: this.cleanSizeConfigs(this.size_configs)
      })
    }
  }
}
</script>

<style scoped>

</style>
