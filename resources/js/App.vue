<script>

import {defineComponent} from "vue";
import HeaderComponent from "./components/HeaderComponent.vue";

export default defineComponent({
    components: {HeaderComponent}
})


</script>

<template>
    <HeaderComponent/>
    <router-view/>
</template>

<style>
body{
    font-family: "Inter var experimental", "Inter var", Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
    background-color: #1a1a1a;
    color: #ffffffde;
}

* {
    padding: 0;
    margin: 0;
    border: 0;
}

*,
*:before,
*:after {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

:focus,
:active {
    outline: none;
}

a:focus,
a:active {
    outline: none;
}

aside,
nav,
footer,
header,
section {
    display: block;
}

input::-ms-clear {
    display: none;
}

button {
    cursor: pointer;
}

button::-moz-focus-inner {
    padding: 0;
    border: 0;
}

a,
a:visited {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

ul li,
ul {
    list-style: none;
}

img {
    vertical-align: top;
    width: 100%;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    font-weight: inherit;
    font-size: inherit;
}

input {
    -webkit-appearance: none;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

input[type='number'],
input[type="number"]:hover,
input[type="number"]:focus {
    -webkit-appearance: none;
    appearance: none;
    -moz-appearance: textfield;
}

.container {
    max-width: 950px;
    margin-inline: auto;
}

.table-wrapper {
    min-height: 554px;
}

table {
    margin-inline: auto;
    border-spacing: 5px;
}

th {
    font-weight: 900;
    padding-block: 10px;
}

td {
    border-radius: 2px;
    padding: 5px 10px;
    background-color: #2f2f2f;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .04), 0 1px 2px rgba(0, 0, 0, .06);
}

tbody tr td:nth-child(1) {
    min-width: 60px;
}

tbody tr td:nth-child(2),
tbody tr td:nth-child(3) {
    min-width: 250px;
}

.btn {
    background-color: #f1f1f1;
    color: #213547;
    border-radius: 2px;
    padding: 10px 20px;
    font-weight: 600;
    transition: .2s;
    width: 100%;
}

.btn-danger {
    color: #f1f1f1;
    background-color: #d92c3f;
}

.btn-danger:hover {
    background-color: #ad1f2f;
}

.btn-success {
    color: #f1f1f1;
    background-color: #42b883;
}

.btn-success:hover {
    background-color: #2d9164;
}

.pagination {
    margin-top: 30px;
    width: fit-content;
    margin-inline: auto;
}

.pagination-links {
    display: flex;
    align-items: center;
    column-gap: 5px;
}

.pagination-links span {
    cursor: pointer;
    border-radius: 2px;
    padding: 5px 10px;
    background-color: #2f2f2f;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .04), 0 1px 2px rgba(0, 0, 0, .06);
    transition: .2s;
    color: #aac8e4;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pagination-links span:hover {
    background-color: #3a3a3a;
}

.pagination-links span.active {
    background-color: #3a3a3a;
    color: #2d9164;
}

input[type="number"] {
    width: 50px;
    border-radius: 2px;
    padding: 8px 10px;
    text-align: center;
    background-color: #5b5858;
    color: #42b883;
    font-weight: 500;
    font-size: 16px;
}

select,
input[type="search"],
input[type="text"],
input[type="email"],
input[type="number"]{
    border-radius: 2px;
    padding: 8px 10px;
    background-color: #5b5858;
    color: #42b883;
    font-size: 16px;
    width: 100%;
    transition: .4s;
}

input[type="text"],
input[type="email"],
input[type="number"],
input[type="search"]{
    background-color: #2f2f2f;
    color: #aac8e4;
}

input[type="text"]::placeholder,
input[type="email"]::placeholder,
input[type="number"]::placeholder,
input[type="search"]::placeholder {
    color: #aac8e4;
    opacity: .6;
}

select{
    color: #aac8e4;
    appearance: none;
    text-align: center;
    cursor: pointer;
}

input[type="text"]:not(:placeholder-shown),
input[type="email"]:not(:placeholder-shown),
input[type="number"]:not(:placeholder-shown),
input[type="search"]:not(:placeholder-shown) {
    background-color: #5b5858;
}

.table-wrapper__header {
    margin-top: 10px;
    margin-left: auto;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.not-found{
    font-size: 40px;
    text-transform: uppercase;
    font-weight: 600;
    text-align: center;
    margin-top: 50px;
    color: #d92c3f;
}

.not-found__message{
    display: block;
}

.not-found__btn{
    margin-top: 15px;
    max-width: 150px;
    margin-inline: auto;
    padding: 14px;
    text-transform: uppercase;
}

.popup-message{
    max-width: 500px;
    min-width: 200px;
    position: fixed;
    top: 50%;
    transform: translate(-50%, -50%);
    border-radius: 2px;
    padding: 15px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .04), 0 1px 2px rgba(0, 0, 0, .06);
    background-color: rgba(28, 27, 27, 0.7);
    text-align: center;
    display: flex;
    flex-direction: column;
    row-gap: 10px;
    left: 50%;
}

.popup-message__content{
    color: #2d9164;
    font-weight: 700;
}

.popup-message__content.error{
    color: #d92c3f;
}

.popup-message__action{
    display: flex;
    align-items: center;
    column-gap: 40px;
}
</style>


