# Warships

## Typy lodí
```
X   XX    X     X
    XX    X    XXX
         XX    X X
```
- ve hře budou přítomny vždycky všechny tyto lodě a každá právě jednou
- lodě mohou být libovolně otočeny (po 90°)
- celkový počet životů lodí je 15 (1 + 4 + 4 + 6)
   
## API
### Registrace hráče       
http://warships.ondrejkrejcir.cz/register.php?name={name}
- 200
    - Registrován do turnaje
- 400
    - Špatný vstup
    
### Střelba
http://warships.ondrejkrejcir.cz/shoot.php?hash={hash}&x={x}&y={y}
- 200
    - Vystřeleno [výsledek: true/false]
- 400
    - Špatný vstup
- 403
    - Nenalezena hra ve které jste na tahu
- 410
    - hra již byla dohrána

### Kontrola vítězství
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
    
### Spuštění testovací hry
http://warships.ondrejkrejcir.cz/simulation.php?hash={hash}
- 400
    - Špatný vstup
    
### Spuštění testovací hry - Brutallus mode
http://warships.ondrejkrejcir.cz/brutallus.php?hash={hash}
- 400
    - Špatný vstup
