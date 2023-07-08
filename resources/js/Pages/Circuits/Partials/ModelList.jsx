import { Card, Row, Col, Button, Space, message, Popconfirm, App, Typography, Tooltip, Input, Select } from 'antd';
import { QuestionCircleOutlined, PlusOutlined } from '@ant-design/icons';
import { EnvironmentOutlined, EyeOutlined, OrderedListOutlined, EditOutlined, DeleteOutlined } from '@ant-design/icons';
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';
import PaginatedTable from '@/Components/PaginatedTable';

const { Title } = Typography;

const ModelList = ({ modelList }) => {

    const { permissions } = usePage().props?.auth || [];
    const [searchItemValue, setSearchItemValue] = useState({
        value: 'circuit',
        label: 'Circuitos'
    });
    const [searchValue, setSearchValue] = useState('');

    const confirm = data => e => {
        router.delete(route('circuit.destroy', data), {
            onSuccess: () => {
                message.success('Se ha eliminado el circuito con éxito');
            }
        });
    }

    const cancel = (e) => {
        message.warning('Se canceló esa acción');
    }

    const columns = [
        {
            title: 'Provincias',
            dataIndex: 'province',
            key: 'province',
            width: '7%',
        },
        {
            title: 'Ciudades',
            dataIndex: 'city',
            key: 'city',
            width: '7%'
        },
        {
            title: 'COD Parroquias',
            dataIndex: 'code_parish',
            key: 'code_parish',
            width: '5%'
        },
        {
            title: 'Parroquias',
            dataIndex: 'parish',
            key: 'parish',
            width: '7%'
        },
        {
            title: 'COD Circuitos',
            dataIndex: 'code_circ',
            key: 'code_circ',
            width: '5%'
        },
        {
            title: 'Circuitos',
            dataIndex: 'display_name_circ',
            key: 'display_name_circ',
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
                        {permissions.includes('circuit.edit') && (
                            <>
                                <Link href={route('circuit.edit', record.key)}>
                                    <Tooltip title={'Editar'}>
                                        <Button size='small' shape='round' className="bg-[#203956]" type='primary' icon={<EditOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )}
                        {permissions.includes('circuit.destroy') && (
                            <>
                                <Tooltip title={'Eliminar'}>
                                    <Popconfirm
                                        title='Eliminación del Circuito'
                                        description={"¿Está seguro que desea eliminar el circuito " + record.display_name_circ+ " ?"}
                                        okText='Si'
                                        cancelText='No'
                                        icon={<QuestionCircleOutlined style={{ color: 'red' }} />}
                                        okButtonProps={{ danger: true, size: 'middle' }}
                                        cancelButtonProps={{ size: 'middle' }}
                                        onConfirm={confirm(record.key)}
                                        onCancel={cancel}
                                    >
                                        <Button size='small' type="primary" danger shape='round' icon={<DeleteOutlined />} />
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
            label: 'Circuitos',
            value: 'circuit'
        }, {
            label: 'Parroquias',
            value: 'parish'
        }, {
            label: 'Ciudades',
            value: 'city'
        }, {
            label: 'Provincias',
            value: 'province'
        }
    ];

    const handleSeach = (value, itemValue) => {
        const iValue = itemValue.value || itemValue;
        router.visit(route('circuit.index', { value: value, key: iValue }), {
            preserveState: true,
            preserveScroll: true,
            method: 'get'
        })
    }


    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Circuitos
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

            <PaginatedTable
                columns={columns}
                dataTable={modelList}
            ></PaginatedTable>

        </>
    );
}

export default ModelList