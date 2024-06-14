CREATE DATABASE bdviajes; 

CREATE TABLE persona(
    /* idPersona int AUTO_INCREMENT, No agrego el atributo autoincremental porque entonces tendría que ser mi clave primaria, no se relacionaría con el responsable por nrodoc,*/  
    nrodoc varchar(15),
    nombre varchar(150) NOT NULL,
    apellido varchar(150) NOT NULL,
    nroTelefono int, 
    PRIMARY KEY (nrodoc) /* por definición, la clave primaria es implícitamente única y no nula. (no hace falta agregar el atributo UNIQUE y NOT NULL) */
);

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) AUTO_INCREMENT=1;

CREATE TABLE responsable (
    rnumeroempleado bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
    rnrodoc varchar(15),
    PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (rnrodoc) REFERENCES persona (nrodoc)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT,
    fecha DATE NOT NULL,
	vdestino varchar(150) NOT NULL,
    vcantmaxpasajeros int NOT NULL,
	idempresa bigint,
    rnumeroempleado bigint NOT NULL,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    pdocumento varchar(15),
	idviaje bigint,
    nroPasaporte int,
    PRIMARY KEY (pdocumento),
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje),	
    FOREIGN KEY (pdocumento) REFERENCES persona (nrodoc)
    ON UPDATE CASCADE 
    ON DELETE CASCADE
    ); 
    
