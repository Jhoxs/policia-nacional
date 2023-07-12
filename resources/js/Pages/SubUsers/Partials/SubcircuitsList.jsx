import { Card, Row, Col, Button, Space, message, Popconfirm, App, Typography, Tooltip, Input, Select, Radio } from 'antd';
import { EditOutlined, DeleteOutlined, QuestionCircleOutlined, PlusOutlined } from '@ant-design/icons';
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';
import PaginatedTable from '@/Components/PaginatedTable';

const { Title } = Typography;

const SubcircuitsList = ({ subcList }) => {

    const { permissions } = usePage().props?.auth || [];
    const { filters } = usePage().props;

    const [searchItemValue, setSearchItemValue] = useState({
        value: 'identification',
        label: 'Identificación'
    });

    const [filterItemValue, setFilterItemValue] = useState(filters.filter || 'all'); 
    const [searchValue, setSearchValue] = useState(filters.value);

    const confirm = data => e => {
        router.delete(route('subuser.destroy', data), {
            onSuccess: () => {
                message.success('Se ha eliminado el subcircuito con éxito');
            }
        });
    }
    const cancel = (e) => {
        message.warning('Se canceló esa acción');
    }

    const columns = [
        {
            title: 'Identificación',
            dataIndex: 'identification',
            key: 'identification',
            width: '7%',
        },
        {
            title: 'Nombre',
            dataIndex: 'name',
            key: 'name',
            width: '7%'
        },
        {
            title: 'Apellido',
            dataIndex: 'last_name',
            key: 'last_name',
            width: '5%'
        },
        {
            title: 'Correo Electrónico',
            dataIndex: 'email',
            key: 'email',
            width: '7%'
        },
        {
            title: 'Subcircuitos',
            dataIndex: 'subcircuits',
            key: 'subcircuits',
            width: '10%'
        },
        {
            title: 'Acciones',
            key: 'action',
            align: 'center',
            width: '15%',
            render: (_, record) => (
                <>
                    <Space size="small">
                        {permissions.includes('subuser.edit') && (record.subcircuits.length > 0) && (
                            <>
                                <Link href={route('subuser.edit', record.key)}>
                                    <Tooltip title={'Editar'}>
                                        <Button size='middle' shape='round' className="bg-[#203956]" type='primary' icon={<EditOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}
                        {permissions.includes('subuser.edit') && (record.subcircuits.length == 0) && (
                            <>
                                <Link href={route('subuser.edit', record.key)}>
                                    <Tooltip title={'Asignar'}>
                                        <Button size='middle' shape='round' className="bg-[#52c41a]" type='primary' icon={<PlusOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}
                        {permissions.includes('subuser.destroy') && (record.subcircuits.length > 0) && (
                            <>
                                <Tooltip title={'Eliminar'}>
                                    <Popconfirm
                                        title='Eliminación del Subcircuito Asignado'
                                        description={"¿Está seguro que desea eliminar la asignacion de este subcircuito " + record.subcircuits + " ?"}
                                        okText='Si'
                                        cancelText='No'
                                        icon={<QuestionCircleOutlined style={{ color: 'red' }} />}
                                        okButtonProps={{ danger: true, size: 'middle' }}
                                        cancelButtonProps={{ size: 'middle' }}
                                        onConfirm={confirm(record.key)}
                                        onCancel={cancel}
                                    >
                                        <Button size='middle' type="primary" danger shape='round' icon={<DeleteOutlined />} />
                                    </Popconfirm>
                                </Tooltip>
                            </>
                        )}
                    </Space>
                </>
            ),
        },
    ];

    const options = [
        {
            label: 'Identificación',
            value: 'identification'
        }, {
            label: 'Nombre',
            value: 'name'
        }, {
            label: 'Subcircuitos',
            value: 'subcircuit'
        },
    ];

    const handleSeach = (value, itemValue) => {
        const iValue = itemValue.value || itemValue;
        router.visit(route('subuser.index', { value: value, key: iValue }), {
            preserveState: true,
            preserveScroll: true,
            method: 'get'
        })
    }


    const handleFilter = (e)  => {
        setFilterItemValue(e.target.value);
        router.visit(route('subuser.index', { filter:e.target.value }), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            method: 'get'
        })
    }

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Usuarios
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>

            <div className="flex justify-end mb-3 ">
                <Space.Compact size='large'>
                    <Select
                        options={options}
                        defaultValue={options[0]}
                        onChange={value => setSearchItemValue(value)}
                    />
                    <Input.Search
                        value={searchValue}
                        onChange={e => setSearchValue(e.target.value)}
                        onSearch={value => handleSeach(value, searchItemValue)}
                    />
                </Space.Compact>
            </div>
            <div className="flex justify-end mb-3">
                <Radio.Group size='small' defaultValue={filterItemValue} onChange={handleFilter}>
                    <Radio.Button value={'all'}> Todos </Radio.Button>
                    <Radio.Button value={'conSub'}> Con Sub </Radio.Button>
                    <Radio.Button value={'sinSub'}> Sin Sub</Radio.Button>
                </Radio.Group>
            </div>

            <PaginatedTable
                columns={columns}
                dataTable={subcList}
            ></PaginatedTable>

        </>
    );
}

export default SubcircuitsList