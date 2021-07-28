const Welcome = () => import('./components/Welcome.vue' /* webpackChunkName: "resource/js/components/welcome" */)
const DocumentoList = () => import('./components/documentos/List.vue' /* webpackChunkName: "resource/js/components/documentos/list" */)
const DocumentoCreate = () => import('./components/documentos/Add.vue' /* webpackChunkName: "resource/js/components/documentos/add" */)
const DocumentoEdit = () => import('./components/documentos/Edit.vue' /* webpackChunkName: "resource/js/components/documentos/edit" */)

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