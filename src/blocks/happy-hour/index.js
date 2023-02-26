
import { registerBlockType } from '@wordpress/blocks'
import {useBlockProps} from '@wordpress/block-editor'
import {useSelect, useDispatch} from '@wordpress/data'
import {useState} from '@wordpress/element'
import apiFetch from '@wordpress/api-fetch';


import './index.scss'

registerBlockType('fsdhh/happy-hour', {
  edit({attributes, setAttributes, context}){

    const blockProps = useBlockProps({className: "fsdhh-happy-hour-admin"});

    const [googleMapsUrl, setGoogleMapsUrl] = useState('');

    const  {happy_hour_times} = useSelect(select => {

      return select('core/editor').getEditedPostAttribute('meta')
      
    })

    const { editPost } = useDispatch('core/editor')

    console.log(happy_hour_times)


    const handleClear = () => {
      editPost({
        meta: {
          happy_hour_times: {
            sunday: {},
            monday: {},
            tuesday: {},
            wednesday: {},
            thursday: {},
            friday: {},
            saturday: {}
          }
        }
      })
    }

    const handleStartTimeChange = (day, val) => {
      console.log(val)
      editPost({
        meta:{
          happy_hour_times: {
            ...happy_hour_times,
            [day]: {
              end: happy_hour_times[day].end,
              start: val
            }
          }
        }
      })
    }

    const handleEndTimeChange = (day, val) => {
      console.log(val)
      editPost({
        meta:{
          happy_hour_times: {
            ...happy_hour_times,
            [day]: {
              start: happy_hour_times[day].start,
              end: val
            }
          }
        }
      })
    }

    const handleGoogleUrlSubmit = async (e) => {
      // Hit custom REST endpoint to handle google API request
      
      // Expected return of object:
      e.preventDefault()

      const placeString = googleMapsUrl.split('/place/')[1].split('/@')[0]
      const lat = googleMapsUrl.split('@')[1].split(',')[0]
      const lng = googleMapsUrl.split('@')[1].split(',')[1]

      const res = await apiFetch({path: 'fsdhh/v1/fetch-google-data', method: "POST", data: {
        placeString: placeString,
        lat: lat,
        lng: lng
      }});

      const json = JSON.parse(res)

      console.log(json)


      // setAttributes({lat: x, long: x, rating: x})

      // image also returned, but not immediatly stored

      // setState(...image...)

      // seperate handler will allow manual saving of image if desired
    }

    return (
      <div {...blockProps}>
        <strong>Happy Hour Schedule</strong>
        <hr />
        {happy_hour_times.hasOwnProperty('sunday') ? (
          <>
            <div style={{display: "grid", gridTemplateColumns: "1fr 1fr 1fr"}}>
              <div>Day</div>
              <div>Start</div>
              <div>End</div>
            </div>
            <hr />
            <div style={{display: "grid", gridTemplateColumns: "1fr 1fr 1fr", gap: "4px"}}> 
            {Object.entries(happy_hour_times)?.map(([day, times]) => (
              <>
              {/* Capitalize first letter */}
              <div>{day.charAt(0).toUpperCase() + day.slice(1)}</div>
              <div>
                <input 
                  name="start"
                  type="time" 
                  value={times.start}
                  onChange={e => {
                    handleStartTimeChange(day, e.target.value)
                  }}
                />
              </div>
              <div>
                <input 
                  name="end"
                  type="time" 
                  value={times.end}
                  onChange={e => {
                    handleEndTimeChange(day, e.target.value)
                  }}
                />
              </div>
              </>
            ))}

          </div>
          </>
        ): (
          <button onClick={handleClear}>Add Timeslots</button>
        )}

        <div className='mt-5'>
          {/* <button onClick={handleGoogleUrlSubmit}>Test Endpoint</button> */}
          <form onSubmit={handleGoogleUrlSubmit}>
            <label htmlFor="googleLink">Link to location on Google maps:</label>
            <input 
              id="googleLink"
              type="text" 
              value={googleMapsUrl}
              onChange={(e) => setGoogleMapsUrl(e.target.value) }
            />
            <button type="submit">Fetch</button>
          </form>
        </div>
        
      </div>
    )
  },
  save(){
    return null
  }
})