import pathlib

MARCAS = ('\u00c3', '\u00c2', '\u00e2\u20ac', '\u00e2\u02dc', '\u00e2\u2013')
EXTENSIONES = {'.php', '.js', '.css', '.md', '.sh', '.html'}


def deshacer_doble(texto):
    """Repara texto UTF-8 que fue leido como Windows-1252 y guardado de nuevo."""
    datos = bytearray()
    for c in texto:
        try:
            datos += c.encode('cp1252')
        except UnicodeEncodeError:
            if ord(c) < 256:
                datos.append(ord(c))
            else:
                raise
    return datos.decode('utf-8')


for ruta in sorted(pathlib.Path('.').rglob('*')):
    if ruta.suffix not in EXTENSIONES or {'docs', '.git'} & set(ruta.parts):
        continue

    datos = ruta.read_bytes()

    # Caso 1: archivo guardado en Latin-1 / Windows-1252 en vez de UTF-8.
    try:
        texto = datos.decode('utf-8')
    except UnicodeDecodeError:
        ruta.write_text(datos.decode('cp1252', errors='replace'), encoding='utf-8')
        print('Convertido a UTF-8:', ruta)
        continue

    # Caso 2: UTF-8 "doble" (acentos convertidos en dos caracteres raros).
    if any(m in texto for m in MARCAS):
        try:
            ruta.write_text(deshacer_doble(texto), encoding='utf-8')
            print('Corregido:', ruta)
        except (UnicodeEncodeError, UnicodeDecodeError):
            print('Revisar a mano:', ruta)

print('Listo.')
