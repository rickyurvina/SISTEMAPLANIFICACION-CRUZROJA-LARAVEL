<?php

return [

    'success' => [
        'added' => '{0}:type creado!|{1}:type creada!',
        'sent' => '{0}:type enviado!|{1}:type enviada!',
        'updated' => '{0}:type actualizado!|{1}:type actualizada!',
        'approved' => '{0}:type aprobado!|{1}:type aprobada!',
        'deleted' => '{0}:type borrado!|{1}:type borrada!',
        'duplicated' => '{0}:type duplicado!|{1}:type duplicada!',
        'imported' => '{0}:type importado!|{1}:type importada!',
        'exported' => '{0}:type exportado!|{1}:type exportada!',
        'enabled' => '{0}:type habilitado!|{1}:type habilitada!',
        'disabled' => '{0}:type deshabilitado!|{1}:type :type deshabilitado!',
        'compraDeleted' => 'Compra eliminada con exito',
        'added_or_updated' => '{0}:type creado / actualizado!|{1}:type creada / actualizada!',
        'document_added' => 'Documento cargado al sistema',
    ],

    'error' => [
        'not_user_company' => 'Error: No tiene permisos para administrar esta empresa!',
        'customer' => 'Error: Usuario no creado! :name ya utiliza esta dirección de correo electrónico.',
        'no_file' => 'Error: Ningún archivo seleccionado!',
        'change_type' => 'Error: No se puede cambiar el tipo porque tiene :text relacionado!',
        'goal_indicator_error' => 'Error: No puede editar la frecuencia del indicador porque ya se han registrado avances',
        'indicator_with_progress' => 'No se puede eliminar el indicador presenta avances',
        'source_in_indicator' => 'No se puede eliminar la Fuente se encuentra relacionada',
        'unit_in_indicator' => 'No se puede eliminar la Unidad  se encuentra relacionada',
        'threshold_in_indicator' => 'No se puede eliminar el Umbral se encuentra relacionado',
        'poa_state' => 'No es posible actualizar estado de POA',
        'plan_already_active' => 'No es posible activar plan, ya existe un plan activo',
        'delete' => 'No es posible borrar el registro, tiene elementos relacionados',
        'updated' => 'No es posible realizar la actualización',
        'approve_permission_denied' => 'Lo sentimos, no tiene permisos para realizar esta accíon',
    ],

    'warning' => [
        'deleted' => 'Advertencia: No puede borrar <b>:name</b> porque tiene :text relacionado.',
        'disabled' => 'Advertencia: No se permite desactivar <b>:name</b> porque tiene :text relacionado.',
        'sure' => 'Está seguro?',
        'delete' => 'La información se eliminará completamente',
        'override' => 'La transacción será anulada',
    ],

    'info' => [
        'empty_attachment' => 'Todavía no se ha cargado ningún archivo relacionado con esta actividad.',
        'no_roles_assigned' => 'Todavía no se han asignado roles. Contacte al administrador.',
        'empty_reports' => 'Todavía no se ha generado el reporte de la Matriz',
        'empty_activities' => 'Todavía no se ha cargado ninguna actividad para el programa',
        'empty_requests' => 'Todavía no se ha generado solicitudes de cambio para este POA',
        'user_not_found' => 'No se ha encontrado ningún usuario',
        'empty_poa' => 'No se han encontrado resultados'
    ]

];
