import { Typography, Card, Space, Button, Empty, Modal, Divider, Collapse, Descriptions, List, Table, Row, Col } from 'antd';
import { Link, router, usePage } from '@inertiajs/react'
import React, { useState, useEffect } from 'react';
import { DownloadOutlined, BgColorsOutlined } from '@ant-design/icons';
import axios from 'axios';

const { Title, Text } = Typography;
const { Panel } = Collapse;


const OrderJob = ({ maintenance, maintenance_types, contracts }) => {

    const { permissions } = usePage().props?.auth || [];
    const [modelPreview, setModelPreview] = useState(false);
    const isManager = permissions.includes('maintenance.manager');
    const { maintenance_types: mt_used, order_start: o_start, contracts: c_used } = maintenance;
    const [matches, setMatches] = useState(false);
    let acumMaintenance = 0;
    let acumContract = 0;
    let indexMantenance = [];
    let indexContract = [];
    let activeMaintenance = [];
    let activeContract = [];

    const panelStyle = {
        margin: 0,
        padding: 0
    };

    useEffect(() => {
        const matchQueryList = window.matchMedia("(max-width: 768px)");
        function handleChange(e) {
            setMatches(e.matches);
        }
        matchQueryList.addEventListener("change", handleChange);
    }, [matches]);


    const item_mt_used = mt_used.map((item, index) => {
        const discard = item.detail.discard_type.includes(maintenance.vehicle.vehicle_type);
        const descList = discard ? item.detail.list.filter(iList => !item.detail.discard_list.includes(item)) : item.detail.list;
        const price = discard ? item.detail.discard_price.reduce((prev, curr) => {
            return prev = prev - curr;
        }, parseFloat(item.price)) : item.price;

        acumMaintenance += parseFloat(price);
        indexMantenance.push(index);

        return {
            key: index,
            label: item.name,
            style: panelStyle,
            children: <Descriptions
                column={{ xxl: 1, xl: 1, lg: 1, md: 1, sm: 1, xs: 1 }}
                style={{ width: '100%' }}
                size='small'
                bordered
                layout={matches ? 'vertical' : 'horizontal'}
            >
                <Descriptions.Item label={'Nombre'} span={1}>{item.name}</Descriptions.Item>
                <Descriptions.Item label={'Precio'} span={1}>{price}</Descriptions.Item>
                <Descriptions.Item label={'Descipción'} span={1}>{item.detail.desciption}</Descriptions.Item>
                <Descriptions.Item label={'Detalles'} span={1}>
                    <List
                        dataSource={descList}
                        renderItem={(item) => (
                            <List.Item>
                                <Text>{item}</Text>
                            </List.Item>
                        )}
                        size='small'
                    />
                </Descriptions.Item>
            </Descriptions>
        }
    });


    const item_c_used = c_used.map((item, index) => {
        const price = parseFloat(item.price);
        acumContract += price;
        indexContract.push(index);

        return {
            key: index,
            label: item.name,
            style: panelStyle,
            children: <Descriptions
                column={{ xxl: 1, xl: 1, lg: 1, md: 1, sm: 1, xs: 1 }}
                style={{ width: '100%' }}
                size='small'
                bordered
                layout={matches ? 'vertical' : 'horizontal'}
            >
                <Descriptions.Item label={'Nombre'}>{item.name}</Descriptions.Item>
                <Descriptions.Item label={'Precio'}>{item.price}</Descriptions.Item>
                <Descriptions.Item label={'Piezas'}>
                    <Table
                        dataSource={item.spares.map(itm => {
                            return {
                                key: itm.id,
                                name: itm.name,
                                price: itm.price
                            }
                        })}
                        columns={[
                            {
                                title: 'Nombre',
                                dataIndex: 'name',
                                key: 'name',
                                align: 'left'
                            }, {
                                title: 'Precio',
                                dataIndex: 'price',
                                key: 'price',
                                align: 'center'
                            }
                        ]}
                        pagination={false}
                    />
                </Descriptions.Item>

            </Descriptions>
        };
    });

    return (
        <>
            < Title level={4} style={{ marginLeft: '5px' }}>
                Orden de Trabajo
            </Title>
            <Divider orientation="left" style={{ marginTop: 20 }}>
                <Title level={5} strong> Mantenimientos </Title>
            </Divider>
            <Collapse
                items={item_mt_used}
                style={{ marginLeft: '5px', marginRight: '15px' }}
                size='small'
                className='customCollapse'
                ghost
            />
            <Divider orientation="left">
                <Title strong level={5}> Contratos </Title>
            </Divider>
            <Collapse
                items={item_c_used}
                style={{ marginLeft: '5px', marginRight: '15px' }}
                size='small'
                ghost
            />
            <Divider orientation="left">
                <Title strong level={5}> Detalles </Title>
            </Divider>
            <Descriptions
                bordered
                column={{ xxl: 1, xl: 1, lg: 1, md: 1, sm: 1, xs: 1 }}
                style={{ width: '100%', paddingLeft: 14, paddingRight: 14, marginBottom: 15 }}
                size='small'
                layout={matches ? 'vertical' : 'horizontal'}
            >
                {mt_used.map((item,index) => {
                    const discard = item.detail.discard_type.includes(maintenance.vehicle.vehicle_type);
                    const price = discard ? item.detail.discard_price.reduce((prev, curr) => {
                        return prev = prev - curr;
                    }, parseFloat(item.price)) : item.price;
                    
                    return (
                        <Descriptions.Item key={item.id + '112'} label={item.name} span={1}> {price} </Descriptions.Item>
                    );
                })}
                {c_used.map((item) => {
                    return (
                        <Descriptions.Item key={item.id + '113'} label={item.name} span={1}> {item.price} </Descriptions.Item>
                    );
                })}
                <Descriptions.Item label={<Text strong>SUBTOTAL</Text>} span={1}> {(acumContract + acumMaintenance).toFixed(2) || '0'} </Descriptions.Item>
                <Descriptions.Item label={<Text strong>IVA 12%</Text>} span={1}> {((acumContract + acumMaintenance) * .12).toFixed(2) || '0'} </Descriptions.Item>
                <Descriptions.Item label={<Text strong>TOTAL</Text>} span={1}> {((acumContract + acumMaintenance) + ((acumContract + acumMaintenance) * .12)).toFixed(2) || '0'} </Descriptions.Item>
            </Descriptions>

            <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                <Col>

                    <Button
                        icon={<BgColorsOutlined />}
                        onClick={() => {
                            window.print();

                        }}
                        style={{ marginTop: 5 }}
                    >
                        Imprimir
                    </Button>

                </Col>
                <Col>
                    <Button
                        icon={<DownloadOutlined />}
                        style={{ marginTop: 5 }}
                        onClick={async e => {
                            //router.post('/download-maintenance-orderjob',{...maintenance});
                            e.preventDefault();

                            const urlHost =  window.location.protocol + '//' + window.location.host + '/download-maintenance-orderjob';
                            
                            await axios({
                                url: urlHost,
                                method: 'post',
                                data:{
                                  ...maintenance  
                                },
                                responseType: 'arraybuffer'
                            }).then((response) => {

                                const url = window.URL.createObjectURL(
                                    new Blob([response.data], { type: "application/pdf" })
                                );

                                const link = document.createElement('a');
                                document.body.appendChild(link);

                                link.href = url;
                                link.setAttribute('download', 'reporte-orden-trabajo.pdf');
                                link.click();

                                // Cleanup.
                                window.URL.revokeObjectURL(url);
                                link.remove();
                                
                            }).catch((error) => {
                                console.log('error', error);
                            })

                            return false;
                        }}
                    >
                        Descargar
                    </Button>
                </Col>
                {isManager && maintenance.status < 3 && (
                    <Col>
                        <Button
                            style={{ marginTop: 5 }}
                            onClick={(e) => {

                                router.post('/finish-maintenance-orderjob',{...maintenance})
                            }}
                        >
                            Finalizar
                        </Button>
                    </Col>
                )}

            </Row>

        </>
    );
}

export default OrderJob;