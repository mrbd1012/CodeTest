import {http, httpFile} from './http_service';

export function createCategory(data) {
    return http().post('/user/categories', data);
}

export function getCategories(){
    return http().get('/user/categories');
}
