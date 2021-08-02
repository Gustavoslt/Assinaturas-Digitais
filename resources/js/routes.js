const Welcome = () => import('./components/Welcome.vue')
const DocumentoList = () => import('./components/documentos/List.vue')
const DocumentoCreate = () => import('./components/documentos/Add.vue')
const DocumentoEdit = () => import('./components/documentos/Edit.vue')

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Welcome
    },
    {
        name: 'documentoList',
        path: '/documento',
        component: DocumentoList
    },
    {
        name: 'documentoEdit',
        path: '/documento/:id/editar',
        component: DocumentoEdit
    },
    {
        name: 'documentoAdd',
        path: '/documento/criar',
        component: DocumentoCreate
    }
]