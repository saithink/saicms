<template>
  <component
    is="a-drawer"
    v-model:visible="visible"
    :width="800"
    :title="title"
    :mask-closable="false"
    :ok-loading="loading"
    @cancel="close"
    @before-ok="submit">
    <!-- 表单信息 start -->
    <a-form ref="formRef" :model="formData" :rules="rules" :auto-label-width="true">
      <a-form-item label="上级菜单" field="parent_id">
        <a-tree-select
          v-model="formData.parent_id"
          :data="treeData"
          :field-names="{ key: 'id', title: 'category_name', icon: 'customIcon' }"
          placeholder="请选择上级菜单"
          allow-clear />
      </a-form-item>
      <a-form-item label="分类标题" field="category_name">
        <a-input v-model="formData.category_name" placeholder="请输入分类标题" />
      </a-form-item>
      <a-form-item label="分类简介" field="describe">
        <a-textarea v-model="formData.describe" placeholder="请输入分类简介" />
      </a-form-item>
      <a-form-item label="分类图片" field="image">
        <sa-upload-image v-model="formData.image" :limit="3" :multiple="false" />
      </a-form-item>
      <a-form-item label="排序" field="sort">
        <a-input-number v-model="formData.sort" placeholder="请输入排序" />
      </a-form-item>
      <a-form-item label="状态" field="status">
        <sa-radio v-model="formData.status" dict="data_status" />
      </a-form-item>
    </a-form>
    <!-- 表单信息 end -->
  </component>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Message, Modal } from '@arco-design/web-vue'
import api from '../../api/news/category'

const emit = defineEmits(['success'])
// 引用定义
const visible = ref(false)
const loading = ref(false)
const formRef = ref()
const mode = ref('')
const treeData = ref([])

let title = computed(() => {
  return '文章分类' + (mode == 'add' ? '-新增' : '-编辑')
})

// 表单信息
const formData = reactive({
  id: null,
  parent_id: null,
  category_name: '',
  describe: '',
  image: '',
  sort: 100,
  status: 1,
})

// 验证规则
const rules = {
  parent_id: [{ required: true, message: '上级菜单必需填写' }],
  category_name: [{ required: true, message: '分类标题必需填写' }],
}

// 打开弹框
const open = async (type = 'add') => {
  mode.value = type
  visible.value = true
  formRef.value.resetFields()
  await initPage()
}

// 初始化页面数据
const initPage = async () => {
  const resp = await api.getPageList()
  treeData.value = resp.data
}

// 设置数据
const setFormData = async (data) => {
  for (const key in formData) {
    if (data[key] != null && data[key] != undefined) {
      formData[key] = data[key]
    }
  }
}

// 数据保存
const submit = async (done) => {
  const validate = await formRef.value?.validate()
  if (!validate) {
    loading.value = true
    let data = { ...formData }
    let result = {}
    if (mode.value === 'add') {
      // 添加数据
      data.id = undefined
      result = await api.save(data)
    } else {
      // 修改数据
      result = await api.update(data.id, data)
    }
    if (result.code === 200) {
      Message.success('操作成功')
      emit('success')
      done(true)
    }
    // 防止连续点击提交
    setTimeout(() => {
      loading.value = false
    }, 500)
  }
  done(false)
}

// 关闭弹窗
const close = () => (visible.value = false)

defineExpose({ open, setFormData })
</script>
