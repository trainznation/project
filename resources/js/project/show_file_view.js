import Plyr from 'plyr'
import * as THREE from "three"
import Stats from "three/examples/jsm/libs/stats.module"

import {OrbitControls} from 'three/examples/jsm/controls/OrbitControls'
import {FBXLoader} from 'three/examples/jsm/loaders/FBXLoader'
import { OBJLoader } from 'three/examples/jsm/loaders/OBJLoader.js';

let codeEditor = document.querySelector('#codeEditor')
let camera, scene, renderer, stats;
let mouseX = 0, mouseY = 0;

let windowHalfX = window.innerWidth / 2;
let windowHalfY = window.innerHeight / 2;

let object;
let mixer;

const player = new Plyr('#player')
const clock = new THREE.Clock()

function initFbx() {
    const container = document.querySelector('#canvas_3d')

    if(container.dataset.type === 'fbx') {
        camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 2000)
        camera.position.set(100,200,300);

        scene = new THREE.Scene()
        scene.background = new THREE.Color( 0xa0a0a0 );
        scene.fog = new THREE.Fog( 0xa0a0a0, 200, 1000 );

        const hemiLight = new THREE.HemisphereLight( 0xffffff, 0x444444 );
        hemiLight.position.set( 0, 200, 0 );
        scene.add( hemiLight );

        const dirLight = new THREE.DirectionalLight( 0xffffff );
        dirLight.position.set( 0, 200, 100 );
        dirLight.castShadow = true;
        dirLight.shadow.camera.top = 180;
        dirLight.shadow.camera.bottom = - 100;
        dirLight.shadow.camera.left = - 120;
        dirLight.shadow.camera.right = 120;
        scene.add( dirLight );

        const mesh = new THREE.Mesh( new THREE.PlaneGeometry( 2000, 2000 ), new THREE.MeshPhongMaterial( { color: 0x999999, depthWrite: false } ) );
        mesh.rotation.x = - Math.PI / 2;
        mesh.receiveShadow = true;
        scene.add( mesh );

        const grid = new THREE.GridHelper( 2000, 20, 0x000000, 0x000000 );
        grid.material.opacity = 0.2;
        grid.material.transparent = true;
        scene.add( grid );

        const loader = new FBXLoader();
        loader.load( container.dataset.uriModel, function ( object ) {

            mixer = new THREE.AnimationMixer( object );

            const action = mixer.clipAction( object.animations[ 0 ] );
            action.play();

            object.traverse( function ( child ) {

                if ( child.isMesh ) {

                    child.castShadow = true;
                    child.receiveShadow = true;

                }

            } );

            scene.add( object );

        } );

        renderer = new THREE.WebGLRenderer( { antialias: true } );
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( window.innerWidth, window.innerHeight );
        renderer.shadowMap.enabled = true;
        container.appendChild( renderer.domElement );

        const controls = new OrbitControls( camera, renderer.domElement );
        controls.target.set( 0, 100, 0 );
        controls.update();

        window.addEventListener( 'resize', onWindowResize );

        stats = new Stats();
        container.appendChild( stats.dom );
    } else if(container.dataset.type === 'obj') {

        camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );
        camera.position.z = 250;

        scene = new THREE.Scene();

        const ambientLight = new THREE.AmbientLight( 0xcccccc, 0.4 );
        scene.add( ambientLight );

        const pointLight = new THREE.PointLight( 0xffffff, 0.8 );
        camera.add( pointLight );
        scene.add( camera );

        function loadModel() {

            object.traverse( function ( child ) {

                if ( child.isMesh ) child.material.map = texture;

            } );

            object.position.y = - 95;
            scene.add( object );

        }

        const manager = new THREE.LoadingManager( loadModel );

        manager.onProgress = function ( item, loaded, total ) {

            console.log( item, loaded, total );

        };

        const textureLoader = new THREE.TextureLoader( manager );
        const texture = textureLoader.load( 'textures/uv_grid_opengl.jpg' );

        function onProgress( xhr ) {

            if ( xhr.lengthComputable ) {

                const percentComplete = xhr.loaded / xhr.total * 100;
                console.log( 'model ' + Math.round( percentComplete, 2 ) + '% downloaded' );

            }

        }

        function onError() {}

        const loader = new OBJLoader( manager );
        loader.load( container.dataset.uriModel, function ( obj ) {

            object = obj;

        }, onProgress, onError );

        renderer = new THREE.WebGLRenderer();
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( window.innerWidth, window.innerHeight );
        container.appendChild( renderer.domElement );

        document.addEventListener( 'mousemove', onDocumentMouseMove );

        //

        window.addEventListener( 'resize', onWindowResize );
    }
}

function onWindowResize() {

    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    renderer.setSize( window.innerWidth, window.innerHeight );

}

function onDocumentMouseMove( event ) {

    mouseX = ( event.clientX - windowHalfX ) / 2;
    mouseY = ( event.clientY - windowHalfY ) / 2;

}

function animate() {

    requestAnimationFrame( animate );

    const delta = clock.getDelta();

    if ( mixer ) mixer.update( delta );

    renderer.render( scene, camera );

    stats.update();

}

function render() {

    camera.position.x += ( mouseX - camera.position.x ) * .05;
    camera.position.y += ( - mouseY - camera.position.y ) * .05;

    camera.lookAt( scene.position );

    renderer.render( scene, camera );

}

CodeMirror.fromTextArea(codeEditor, {
    lineNumbers: true,
    matchBrackets: true,
    tabSize: 2,
    mode: codeEditor.dataset.type,
    theme: 'monokai',
    gutters: ['error']
});

init()
animate()






