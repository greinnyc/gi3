ALTER TABLE DB_Invitado.dbo.invitados ALTER COLUMN fecha_registro datetime NOT NULL GO
ALTER TABLE DB_Invitado.dbo.invitados ALTER COLUMN fecha_modificacion datetime NOT NULL GO

ALTER TABLE DB_Invitado.dbo.ingreso_evento DROP CONSTRAINT ingreso_evento_fk1 GO
ALTER TABLE DB_Invitado.dbo.ingreso_evento DROP COLUMN programacion_codigo GO

ALTER TABLE DB_Invitado.dbo.eventos ADD sede_codigo int NULL GO
ALTER TABLE DB_Invitado.dbo.eventos ADD ubicacion_codigo int NULL GO

ALTER TABLE DB_Invitado.dbo.ingreso_evento ADD usuario_registro int NOT NULL GO
ALTER TABLE DB_Invitado.dbo.log_acciones_evento ALTER COLUMN fecha_registro datetime NOT NULL GO
