import { Card, Row, Col, Button, Space, message, Popconfirm, Tag, Typography, Tooltip, Input, Select, Radio } from 'antd';
import { EditOutlined, DeleteOutlined, QuestionCircleOutlined, PlusOutlined } from '@ant-design/icons';
import collectionColors from '/resources/js/Providers/ColorProvider.js'
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';
import PaginatedTable from '@/Components/PaginatedTable';

const { Title } = Typography;
const { colorVehicles } = collectionColors;

const SubcircuitsList = ({ subcList }) => {

    const { permissions } = usePage().props?.auth || [];
    const { filters } = usePage().props;

    const [searchItemValue, setSearchItemValue] = useState({
        value: 'plate',
        label: 'Placa'
    });
    
    const [filterItemValue, setFilterItemValue] = useState(filters.filter || 'all'); 
    const [searchValue, setSearchValue] = useState(filters.value);

    const confirm = data => e => {
        router.delete(route('uservehicle.destroy', data), {
            
        });
    }
    const cancel = (e) => {
        message.warning('Se canceló esa acción');
    }
    
    const columns = [
        {
            title: 'Placa',
            dataIndex: 'plate',
            key: 'plate',
            width: '10%',
        },
        {
            title: 'Marca',
            dataIndex: 'brand',
            key: 'brand',
            width: '10%'
        },
        {
            title: 'Tipo de Vehículo',
            dataIndex: 'vehicle_type',
            width: '10%',
            key: 'vehicle_type',
            render: (_, { vehicle_type }) => {
                let color;
                color = colorVehicles[vehicle_type.toUpperCase()] || 'blue'

                return (
                    <>
                        <Tag color={color} key={vehicle_type}>
                            {vehicle_type.toUpperCase()}
                        </Tag>
                    </>
                );
            },
        },
        {
            title: 'Usuarios (Identificación)',
            dataIndex: 'users',
            key: 'users',
            width: '15%',
            render: (_, { users }) => (
                <>
                    {users.map((rol) => {
                        let color;

                        color =  'blue'

                        return (
                            <Tag color={color} key={rol}>
                                {rol.toUpperCase()}
                            </Tag>
                        );
                    })}
                </>
            ),
        },
        {
            title: 'Distrito',
            dataIndex: 'cities',
            key: 'cities',
            width: '10%'
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
                        {permissions.includes('uservehicle.edit') && (record.subcircuits.length > 0) && (record.users.length > 0) && (
                            <>
                                <Link href={route('uservehicle.edit', record.key)}>
                                    <Tooltip title={'Editar'}>
                                        <Button size='middle' shape='round' className="bg-[#203956]" type='primary' icon={<EditOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}
                        {permissions.includes('subvehicle.edit') && (record.subcircuits.length == 0)   && (
                            <>
                                <Link href={route('subvehicle.edit', record.key)}>
                                    <Tooltip title={'Asignar Subcircuito'}>
                                        <Button size='middle' shape='round' icon={<PlusOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}
                        {permissions.includes('uservehicle.edit') && (record.subcircuits.length > 0) && (record.users.length == 0) && (
                            <>
                                <Link href={route('uservehicle.edit', record.key)}>
                                    <Tooltip title={'Asignar Usuarios'}>
                                        <Button size='middle' shape='round' className="bg-[#52c41a]" type='primary' icon={<PlusOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}
                        {permissions.includes('uservehicle.destroy') && (record.subcircuits.length > 0) && (record.users.length > 0) && (
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
            label: 'Placa',
            value: 'plate'
        }, 
        {
            label: 'Marca',
            value: 'brand'
        }, 
        {
            label: 'Tipo de Vehículo',
            value: 'vehicle_type'
        }, 
        {
            label: 'Subcircuitos',
            value: 'subcircuit'
        },
    ];


    const handleSeach = (value, itemValue) => {
        const iValue = itemValue.value || itemValue;
        router.visit(route('uservehicle.index', { value: value, key: iValue }), {
            preserveState: true,
            preserveScroll: true,
            method: 'get'
        })
    }


    const handleFilter = (e)  => {
        setFilterItemValue(e.target.value);
        router.visit(route('uservehicle.index', { filter:e.target.value }), {
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
                    Vehículos
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
                    <Radio.Button value={'conUsr'}> Con Usr </Radio.Button>
                    <Radio.Button value={'sinUsr'}> Sin Usr</Radio.Button>
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