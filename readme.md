http://warships.ondrejkrejcir.cz/register.php?name={name}
- 200
    - Registrován do turnaje
- 400
    - Špatný vstup
    
http://warships.ondrejkrejcir.cz/shoot.php?hash={hash}&x={x}&y={y}
- 200
    - Vystřeleno [výsledek: true/false]
- 400
    - Špatný vstup
- 403
    - Nenalezena hra ve které jste na tahu
- 410
    - hra již byla dohrána

http://warships.ondrejkrejcir.cz/check.php?hash={hash}
- 200
    - Vítězství!
- 204
    - Zatím jste nevyhrál.
- 400
    - Špatný vstup
- 403
    - Nenalezena hra ve které jste na tahu
- 410
    - hra již byla dohrána
    
http://warships.ondrejkrejcir.cz/simulation.php?hash={hash}
- 400
    - Špatný vstup
