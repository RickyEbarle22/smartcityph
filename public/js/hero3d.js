/* SmartCity PH — Three.js 3D City Hero (r128) */

(function () {
  'use strict';
  if (typeof THREE === 'undefined') return;
  const container = document.getElementById('hero3d');
  if (!container) return;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isMobile = window.innerWidth < 768;

  const W = () => container.clientWidth || window.innerWidth;
  const H = () => container.clientHeight || window.innerHeight;

  const scene = new THREE.Scene();
  scene.fog = new THREE.FogExp2(0x020617, 0.018);
  scene.background = new THREE.Color(0x020617);

  const camera = new THREE.PerspectiveCamera(70, W() / H(), 0.1, 200);
  camera.position.set(28, 14, 28);
  camera.lookAt(0, 5, 0);

  const renderer = new THREE.WebGLRenderer({ antialias: !isMobile, alpha: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.6));
  renderer.setSize(W(), H());
  container.appendChild(renderer.domElement);

  // Lights
  scene.add(new THREE.AmbientLight(0x111827, 0.7));
  const dir = new THREE.DirectionalLight(0x06B6D4, 0.45);
  dir.position.set(10, 20, 10);
  scene.add(dir);

  // Ground plane (very dark)
  const groundMat = new THREE.MeshBasicMaterial({ color: 0x05080F });
  const ground = new THREE.Mesh(new THREE.PlaneGeometry(120, 120), groundMat);
  ground.rotation.x = -Math.PI / 2;
  ground.position.y = -0.05;
  scene.add(ground);

  // Buildings
  const buildings = [];
  const buildingCount = isMobile ? 22 : 48;
  const cityRange = 22;
  const cyan = new THREE.Color(0x06B6D4);
  const blue = new THREE.Color(0x2563EB);

  for (let i = 0; i < buildingCount; i++) {
    const w = 1 + Math.random() * 2.2;
    const d = 1 + Math.random() * 2.2;
    const h = 3 + Math.random() * 22;

    const geom = new THREE.BoxGeometry(w, h, d);
    const mat = new THREE.MeshStandardMaterial({
      color: 0x1A2035,
      roughness: 0.85,
      metalness: 0.05,
      emissive: new THREE.Color(0x05080F),
    });
    const mesh = new THREE.Mesh(geom, mat);
    mesh.position.x = (Math.random() - 0.5) * cityRange * 2;
    mesh.position.z = (Math.random() - 0.5) * cityRange * 2;
    mesh.position.y = h / 2;

    // Edge glow
    const edges = new THREE.EdgesGeometry(geom);
    const edgeColor = Math.random() > 0.4 ? cyan : blue;
    const lineMat = new THREE.LineBasicMaterial({ color: edgeColor, transparent: true, opacity: 0.7 });
    const lines = new THREE.LineSegments(edges, lineMat);
    mesh.add(lines);

    mesh.userData = {
      basePulse: 0.55 + Math.random() * 0.4,
      pulseSpeed: 0.4 + Math.random() * 0.6,
      lineMat: lineMat,
    };

    scene.add(mesh);
    buildings.push(mesh);
  }

  // Particles
  const particleCount = isMobile ? 220 : 500;
  const pGeo = new THREE.BufferGeometry();
  const positions = new Float32Array(particleCount * 3);
  for (let i = 0; i < particleCount; i++) {
    positions[i * 3]     = (Math.random() - 0.5) * 80;
    positions[i * 3 + 1] = Math.random() * 50;
    positions[i * 3 + 2] = (Math.random() - 0.5) * 80;
  }
  pGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  const pMat = new THREE.PointsMaterial({
    color: 0xFCD116,
    size: 0.16,
    transparent: true,
    opacity: 0.7,
    sizeAttenuation: true,
  });
  const particles = new THREE.Points(pGeo, pMat);
  scene.add(particles);

  // Golden sun
  const sunGeom = new THREE.SphereGeometry(2.5, 32, 32);
  const sunMat = new THREE.MeshBasicMaterial({ color: 0xFCD116, transparent: true, opacity: 0.85 });
  const sun = new THREE.Mesh(sunGeom, sunMat);
  sun.position.set(-12, 14, -28);
  scene.add(sun);

  const sunLight = new THREE.PointLight(0xFCD116, 1.2, 60);
  sunLight.position.copy(sun.position);
  scene.add(sunLight);

  // Sun glow halo (sprite-like)
  const haloGeom = new THREE.SphereGeometry(3.5, 32, 32);
  const haloMat = new THREE.MeshBasicMaterial({ color: 0xFCD116, transparent: true, opacity: 0.18, side: THREE.BackSide });
  const halo = new THREE.Mesh(haloGeom, haloMat);
  halo.position.copy(sun.position);
  scene.add(halo);

  // Animation loop
  let clock = new THREE.Clock();
  const orbitRadius = 30;
  const orbitSpeed = reduceMotion ? 0 : 0.06;

  function tick() {
    const t = clock.getElapsedTime();
    if (!reduceMotion) {
      camera.position.x = orbitRadius * Math.cos(t * orbitSpeed);
      camera.position.z = orbitRadius * Math.sin(t * orbitSpeed);
      camera.position.y = 12 + Math.sin(t * 0.2) * 1.6;
      camera.lookAt(0, 5, 0);

      // Pulse buildings
      buildings.forEach((b, i) => {
        const ud = b.userData;
        const factor = ud.basePulse + Math.sin(t * ud.pulseSpeed + i) * 0.25;
        ud.lineMat.opacity = 0.4 + factor * 0.5;
      });

      // Particles drift
      const arr = pGeo.attributes.position.array;
      for (let i = 1; i < arr.length; i += 3) {
        arr[i] += 0.012;
        if (arr[i] > 50) arr[i] = 0;
      }
      pGeo.attributes.position.needsUpdate = true;

      // Sun pulse
      sunMat.opacity = 0.7 + Math.sin(t * 0.6) * 0.15;
    }
    renderer.render(scene, camera);
    requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);

  // Resize
  function onResize() {
    const w = W(), h = H();
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
  }
  window.addEventListener('resize', onResize);
})();
