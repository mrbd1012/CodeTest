import {http, httpFile} from "./http_service";
import jwt from 'jsonwebtoken';
import store from "../store";


export function register(user){
    return http().post('/auth/register', user);

}

export function login(user){
    return http().post('/auth/login', user)
        .then(res => {
            if (res.status === 200){
                setToken(res.data)
            }
            return res.data;
        })
}

export function logout(){
    http().get('/auth/logout');
    localStorage.removeItem('code-test-user-token');
    return;

}

function setToken(user){
    const token = jwt.sign({ user: user }, 'codeTest')
    return localStorage.setItem('code-test-user-token', token);
    store.dispatch('authenticate', user.user);
}

export function getAccessToken(){
    const token = localStorage.getItem('code-test-user-token');
    if(!token){
        return null;
    }
    const tokenData = jwt.decode(token);
    return tokenData.user.access_token;
}

export function getProfile(){
    http().get('/auth/user-profile');
}
